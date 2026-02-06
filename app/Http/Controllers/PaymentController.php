<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function show($orderNumber)
    {
        $order = Order::with(['items.book', 'payment'])
            ->where('user_id', Auth::id())
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        // Check if already paid
        if ($order->payment && $order->payment->status === 'success') {
            return redirect()->route('orders.show', $order->order_number)
                ->with('info', 'Pesanan ini sudah dibayar');
        }

        return view('payment.show', compact('order'));
    }

    public function process(Request $request, $orderNumber)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        $request->validate([
            'payment_method' => 'required|in:bank_transfer,credit_card,e_wallet',
        ]);

        // Create or update payment record
        $payment = Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'payment_method' => $request->payment_method,
                'payment_gateway' => 'manual', // Will be changed to 'midtrans' or 'xendit' later
                'amount' => $order->total_amount,
                'status' => 'pending',
            ]
        );

        // TODO: Integrate with actual payment gateway (Midtrans/Xendit)
        // For now, we'll simulate a successful payment

        return redirect()->route('payment.confirmation', $order->order_number);
    }

    public function confirmation($orderNumber)
    {
        $order = Order::with(['items.book', 'payment'])
            ->where('user_id', Auth::id())
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        return view('payment.confirmation', compact('order'));
    }

    public function callback(Request $request)
    {
        // This will be used for payment gateway callbacks (Midtrans/Xendit)
        // TODO: Implement payment gateway callback handling

        return response()->json(['status' => 'success']);
    }
}
