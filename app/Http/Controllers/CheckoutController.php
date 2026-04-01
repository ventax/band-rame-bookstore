<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    private function parseSelectedItemIds(Request $request): array
    {
        $selected = $request->input('selected_items', []);

        if (is_string($selected)) {
            $selected = explode(',', $selected);
        }

        if (!is_array($selected)) {
            return [];
        }

        return collect($selected)
            ->map(fn($id) => (int) $id)
            ->filter(fn($id) => $id > 0)
            ->unique()
            ->values()
            ->all();
    }

    private function resolveCheckoutSelection(Request $request): array
    {
        $allUserCartIds = Cart::where('user_id', Auth::id())->pluck('id')->all();
        $hasSelectionInput = $request->has('selected_items');
        $requestedIds = $this->parseSelectedItemIds($request);

        if (!$hasSelectionInput) {
            $selectedItemIds = $allUserCartIds;
        } else {
            $selectedItemIds = collect($requestedIds)
                ->filter(fn($id) => in_array($id, $allUserCartIds))
                ->values()
                ->all();
        }

        $cartItems = Cart::with('book')
            ->where('user_id', Auth::id())
            ->whereIn('id', $selectedItemIds)
            ->get();

        return [$cartItems, $selectedItemIds, $hasSelectionInput];
    }

    // Step 1: Show address selection/form
    public function address(Request $request)
    {
        [$cartItems, $selectedItemIds, $hasSelectionInput] = $this->resolveCheckoutSelection($request);

        if ($cartItems->isEmpty()) {
            if ($hasSelectionInput) {
                return redirect()->route('cart.index')->with('error', 'Pilih minimal satu item untuk checkout.');
            }

            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong');
        }

        $addresses = Address::where('user_id', Auth::id())->get();
        $defaultAddress = $addresses->where('is_default', true)->first();

        return view('checkout.address', compact('cartItems', 'addresses', 'defaultAddress', 'selectedItemIds'));
    }

    // Step 2: Show payment method selection
    public function payment(Request $request)
    {
        [$cartItems, $selectedItemIds, $hasSelectionInput] = $this->resolveCheckoutSelection($request);

        if ($cartItems->isEmpty()) {
            if ($hasSelectionInput) {
                return redirect()->route('cart.index')->with('error', 'Pilih minimal satu item untuk checkout.');
            }

            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong');
        }

        // Validate address
        $addressId = $request->address_id;
        $address = null;

        if ($addressId) {
            $address = Address::where('user_id', Auth::id())->findOrFail($addressId);
        } else {
            // Use form data
            $request->validate([
                'recipient_name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'required|string',
                'city' => 'required|string|max:100',
                'province' => 'required|string|max:100',
                'postal_code' => 'required|string|max:10',
            ]);
        }

        // Calculate totals
        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->book->discounted_price;
        });

        $shippingCost = 0;
        $grandTotal = $subtotal;

        return view('checkout.payment', compact('cartItems', 'address', 'subtotal', 'shippingCost', 'grandTotal', 'selectedItemIds'));
    }

    // Step 3: Process checkout and create order
    public function process(Request $request)
    {
        $request->validate([
            'selected_items' => 'required|array|min:1',
            'selected_items.*' => 'integer',
            'address_id' => 'nullable|exists:addresses,id',
            'recipient_name' => 'required_without:address_id|string|max:255',
            'phone' => 'required_without:address_id|string|max:20',
            'address' => 'required_without:address_id|string',
            'city' => 'required_without:address_id|string|max:100',
            'province' => 'required_without:address_id|string|max:100',
            'postal_code' => 'required_without:address_id|string|max:10',
            'notes' => 'nullable|string|max:500',
        ]);

        // Selalu gunakan Midtrans sebagai payment method
        $request->merge(['payment_method' => 'midtrans']);

        [$cartItems, $selectedItemIds] = $this->resolveCheckoutSelection($request);

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong');
        }

        // Get or create address data
        if ($request->address_id) {
            $address = Address::where('user_id', Auth::id())->findOrFail($request->address_id);
            $shippingData = [
                'shipping_name' => $address->recipient_name,
                'shipping_phone' => $address->phone,
                'shipping_address' => $address->address,
                'shipping_city' => $address->city,
                'shipping_province' => $address->province,
                'shipping_postal_code' => $address->postal_code,
            ];
        } else {
            $shippingData = [
                'shipping_name' => $request->recipient_name,
                'shipping_phone' => $request->phone,
                'shipping_address' => $request->address,
                'shipping_city' => $request->city,
                'shipping_province' => $request->province,
                'shipping_postal_code' => $request->postal_code,
            ];
        }

        DB::beginTransaction();
        try {
            // Calculate totals
            $subtotal = $cartItems->sum(function ($item) {
                return $item->quantity * $item->book->discounted_price;
            });

            $shippingCost = 0;
            $grandTotal = $subtotal;

            $paymentStatus = Order::PAYMENT_UNPAID;
            $orderStatus   = Order::STATUS_PENDING;

            // Create Order
            $order = Order::create(array_merge($shippingData, [
                'order_number' => Order::generateOrderNumber(),
                'user_id' => Auth::id(),
                'total_amount' => $subtotal,
                'shipping_cost' => $shippingCost,
                'discount_amount' => 0,
                'grand_total' => $grandTotal,
                'status' => $orderStatus,
                'payment_method' => $request->payment_method,
                'payment_status' => $paymentStatus,
                'shipping_email' => Auth::user()->email,
                'notes' => $request->notes,
            ]));

            // Create Order Items & Update Stock
            foreach ($cartItems as $item) {
                // Check stock availability
                if ($item->book->stock < $item->quantity) {
                    throw new \Exception("Stok buku '{$item->book->title}' tidak mencukupi");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $item->book_id,
                    'quantity' => $item->quantity,
                    'price' => $item->book->discounted_price,
                ]);

                // Update stock
                $item->book->decrement('stock', $item->quantity);
            }

            // Clear cart
            Cart::where('user_id', Auth::id())
                ->whereIn('id', $selectedItemIds)
                ->delete();

            DB::commit();

            // Generate Midtrans Snap URL
            MidtransConfig::$serverKey    = config('services.midtrans.server_key');
            MidtransConfig::$isProduction = (bool) config('services.midtrans.is_production');
            MidtransConfig::$isSanitized  = (bool) config('services.midtrans.sanitize');
            MidtransConfig::$is3ds        = (bool) config('services.midtrans.enable_3ds');

            $user = Auth::user();
            $midtransItems = $order->items->map(fn($item) => [
                'id'       => (string) $item->book_id,
                'price'    => max(1, (int) round((float) $item->price)),
                'quantity' => (int) $item->quantity,
                'name'     => mb_substr($item->book->title, 0, 50),
            ])->toArray();

            $grossAmount = collect($midtransItems)->sum(fn($item) => $item['price'] * $item['quantity']);

            if ($grossAmount < 1) {
                throw new \Exception('Total transaksi Midtrans minimal Rp 1.');
            }

            $snapParams = [
                'transaction_details' => [
                    'order_id'     => $order->order_number,
                    'gross_amount' => (int) $grossAmount,
                ],
                'customer_details' => [
                    'first_name' => $order->shipping_name,
                    'email'      => $user->email,
                    'phone'      => $order->shipping_phone,
                    'billing_address' => [
                        'first_name'   => $order->shipping_name,
                        'email'        => $user->email,
                        'phone'        => $order->shipping_phone,
                        'address'      => $order->shipping_address,
                        'city'         => $order->shipping_city,
                        'postal_code'  => $order->shipping_postal_code,
                        'country_code' => 'IDN',
                    ],
                    'shipping_address' => [
                        'first_name'   => $order->shipping_name,
                        'email'        => $user->email,
                        'phone'        => $order->shipping_phone,
                        'address'      => $order->shipping_address,
                        'city'         => $order->shipping_city,
                        'postal_code'  => $order->shipping_postal_code,
                        'country_code' => 'IDN',
                    ],
                ],
                'item_details' => $midtransItems,
                'callbacks' => [
                    'finish' => route('checkout.midtrans.finish'),
                ],
            ];

            $snapUrl = Snap::createTransaction($snapParams)->redirect_url;

            return redirect($snapUrl);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')
                ->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }

    // Midtrans finish callback (GET redirect dari Midtrans setelah bayar)
    public function midtransFinish(Request $request)
    {
        $orderNumber       = $request->query('order_id');
        $transactionStatus = $request->query('transaction_status');

        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->first();

        if ($order) {
            if (in_array($transactionStatus, ['capture', 'settlement'])) {
                $order->update([
                    'payment_status' => Order::PAYMENT_PAID,
                    'status'         => Order::STATUS_PROCESSING,
                    'paid_at'        => now(),
                ]);
            } elseif ($transactionStatus === 'pending') {
                $order->update(['payment_status' => Order::PAYMENT_UNPAID]);
            } elseif (in_array($transactionStatus, ['cancel', 'expire', 'deny', 'failure'])) {
                $order->update([
                    'payment_status' => 'failed',
                    'status'         => Order::STATUS_CANCELLED,
                ]);
            }
        }

        return redirect()->route('checkout.success', $orderNumber)
            ->with('success', 'Pembayaran berhasil diproses!');
    }

    // Success page
    public function success($orderNumber)
    {
        $order = Order::with(['items.book'])
            ->where('user_id', Auth::id())
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        return view('checkout.success', compact('order'));
    }
}
