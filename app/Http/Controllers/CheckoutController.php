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
    // Step 1: Show address selection/form
    public function address()
    {
        $cartItems = Cart::with('book')->where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong');
        }

        $addresses = Address::where('user_id', Auth::id())->get();
        $defaultAddress = $addresses->where('is_default', true)->first();

        return view('checkout.address', compact('cartItems', 'addresses', 'defaultAddress'));
    }

    // Step 2: Show payment method selection
    public function payment(Request $request)
    {
        $cartItems = Cart::with('book')->where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
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

        $shippingCost = 15000; // Flat rate, bisa diubah sesuai kebutuhan

        $grandTotal = $subtotal + $shippingCost;

        return view('checkout.payment', compact('cartItems', 'address', 'subtotal', 'shippingCost', 'grandTotal'));
    }

    // Step 3: Process checkout and create order
    public function process(Request $request)
    {
        $request->validate([
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

        $cartItems = Cart::with('book')->where('user_id', Auth::id())->get();

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

            $shippingCost = 15000;
            $grandTotal = $subtotal + $shippingCost;

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
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            // Generate Midtrans Snap URL
            MidtransConfig::$serverKey    = config('services.midtrans.server_key');
            MidtransConfig::$isProduction = config('services.midtrans.is_production');
            MidtransConfig::$isSanitized  = config('services.midtrans.sanitize');
            MidtransConfig::$is3ds        = config('services.midtrans.enable_3ds');

            $user = Auth::user();
            $snapParams = [
                'transaction_details' => [
                    'order_id'     => $order->order_number,
                    'gross_amount' => (int) $order->grand_total,
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
                'item_details' => $order->items->map(fn($item) => [
                    'id'       => (string) $item->book_id,
                    'price'    => (int) $item->price,
                    'quantity' => $item->quantity,
                    'name'     => mb_substr($item->book->title, 0, 50),
                ])->concat([[
                    'id'       => 'SHIPPING',
                    'price'    => (int) $order->shipping_cost,
                    'quantity' => 1,
                    'name'     => 'Ongkos Kirim',
                ]])->toArray(),
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
