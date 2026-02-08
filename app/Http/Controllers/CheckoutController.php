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
            return $item->quantity * $item->book->price;
        });

        $shippingCost = 15000; // Flat rate, bisa diubah sesuai kebutuhan

        $grandTotal = $subtotal + $shippingCost;

        return view('checkout.payment', compact('cartItems', 'address', 'subtotal', 'shippingCost', 'grandTotal'));
    }

    // Step 3: Process checkout and create order
    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:transfer_bank,cod',
            'address_id' => 'nullable|exists:addresses,id',
            'recipient_name' => 'required_without:address_id|string|max:255',
            'phone' => 'required_without:address_id|string|max:20',
            'address' => 'required_without:address_id|string',
            'city' => 'required_without:address_id|string|max:100',
            'province' => 'required_without:address_id|string|max:100',
            'postal_code' => 'required_without:address_id|string|max:10',
            'notes' => 'nullable|string|max:500',
        ]);

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
                return $item->quantity * $item->book->price;
            });

            $shippingCost = 15000;
            $grandTotal = $subtotal + $shippingCost;

            // Determine payment and order status
            $paymentStatus = $request->payment_method === Order::PAYMENT_COD
                ? Order::PAYMENT_UNPAID
                : Order::PAYMENT_UNPAID;

            $orderStatus = $request->payment_method === Order::PAYMENT_COD
                ? Order::STATUS_PROCESSING
                : Order::STATUS_PENDING;

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
                    'price' => $item->book->price,
                ]);

                // Update stock
                $item->book->decrement('stock', $item->quantity);
            }

            // Clear cart
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
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
