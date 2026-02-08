<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    // List all orders with filters
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.book']);

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->has('payment_status') && $request->payment_status !== '') {
            $query->where('payment_status', $request->payment_status);
        }

        // Search by order number or customer name/email
        if ($request->has('search') && $request->search !== '') {
            $query->where(function ($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                    ->orWhereHas('user', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%')
                            ->orWhere('email', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $orders = $query->latest()->paginate(15);

        // Statistics for dashboard
        $stats = [
            'total' => Order::count(),
            'pending' => Order::where('status', Order::STATUS_PENDING)->count(),
            'processing' => Order::where('status', Order::STATUS_PROCESSING)->count(),
            'shipped' => Order::where('status', Order::STATUS_SHIPPED)->count(),
            'delivered' => Order::where('status', Order::STATUS_DELIVERED)->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    // Show order detail
    public function show(Order $order)
    {
        $order->load(['user', 'items.book']);
        return view('admin.orders.show', compact('order'));
    }

    // Update order status
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,processing,shipped,delivered,cancelled',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        DB::beginTransaction();
        try {
            // Update status
            $order->update(['status' => $newStatus]);

            // Additional actions based on status
            if ($newStatus === Order::STATUS_SHIPPED && !$order->shipped_at) {
                $order->update(['shipped_at' => now()]);
            }

            if ($newStatus === Order::STATUS_DELIVERED && !$order->delivered_at) {
                $order->update(['delivered_at' => now()]);
            }

            // If cancelled, restore stock
            if ($newStatus === Order::STATUS_CANCELLED && $oldStatus !== Order::STATUS_CANCELLED) {
                foreach ($order->items as $item) {
                    $item->book->increment('stock', $item->quantity);
                }
            }

            DB::commit();

            return redirect()->back()
                ->with('success', 'Status pesanan berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal update status: ' . $e->getMessage());
        }
    }

    // Verify payment (approve payment proof)
    public function verifyPayment(Request $request, Order $order)
    {
        if (!$order->payment_proof) {
            return redirect()->back()
                ->with('error', 'Belum ada bukti pembayaran yang diupload');
        }

        $request->validate([
            'action' => 'required|in:approve,reject',
        ]);

        if ($request->action === 'approve') {
            $order->update([
                'payment_status' => Order::PAYMENT_PAID,
                'status' => Order::STATUS_PROCESSING,
                'paid_at' => now(),
            ]);

            return redirect()->back()
                ->with('success', 'Pembayaran berhasil diverifikasi! Status order diubah menjadi Processing.');
        } else {
            $order->update([
                'payment_status' => Order::PAYMENT_FAILED,
                'payment_proof' => null,
            ]);

            return redirect()->back()
                ->with('success', 'Pembayaran ditolak. Customer dapat upload bukti pembayaran baru.');
        }
    }

    // Delete order (hanya untuk testing/development)
    public function destroy(Order $order)
    {
        // Restore stock
        foreach ($order->items as $item) {
            $item->book->increment('stock', $item->quantity);
        }

        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil dihapus!');
    }
}
