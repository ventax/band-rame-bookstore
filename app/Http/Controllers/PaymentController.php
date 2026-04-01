<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config as MidtransConfig;
use Midtrans\Notification;

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
        MidtransConfig::$serverKey    = config('services.midtrans.server_key');
        MidtransConfig::$isProduction = (bool) config('services.midtrans.is_production');
        MidtransConfig::$isSanitized  = (bool) config('services.midtrans.sanitize');
        MidtransConfig::$is3ds        = (bool) config('services.midtrans.enable_3ds');

        try {
            $notification = new Notification();
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }

        $orderNumber       = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $fraudStatus       = $notification->fraud_status;

        $order = Order::where('order_number', $orderNumber)->first();
        if (!$order) {
            return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
        }

        if ($transactionStatus === 'capture') {
            if ($fraudStatus === 'challenge') {
                $order->update(['payment_status' => Order::PAYMENT_UNPAID]);
            } elseif ($fraudStatus === 'accept') {
                $order->update(['payment_status' => Order::PAYMENT_PAID, 'status' => Order::STATUS_PROCESSING, 'paid_at' => now()]);
                Payment::updateOrCreate(
                    ['order_id' => $order->id],
                    ['payment_method' => 'midtrans', 'payment_gateway' => 'midtrans', 'amount' => $order->grand_total, 'status' => 'success']
                );
            }
        } elseif ($transactionStatus === 'settlement') {
            $order->update(['payment_status' => Order::PAYMENT_PAID, 'status' => Order::STATUS_PROCESSING, 'paid_at' => now()]);
            Payment::updateOrCreate(
                ['order_id' => $order->id],
                ['payment_method' => 'midtrans', 'payment_gateway' => 'midtrans', 'amount' => $order->grand_total, 'status' => 'success']
            );
        } elseif ($transactionStatus === 'pending') {
            $order->update(['payment_status' => Order::PAYMENT_UNPAID]);
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel', 'failure'])) {
            $order->update(['payment_status' => 'failed', 'status' => Order::STATUS_CANCELLED]);
        }

        return response()->json(['status' => 'ok']);
    }
}
