<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminOrderController extends Controller
{
    // API endpoint untuk polling notifikasi pesanan baru
    public function checkNewOrders(Request $request)
    {
        $lastId    = (int) $request->query('last_id', 0);
        $latestId  = Order::max('id') ?? 0;

        // Cari semua pesanan baru (ID lebih besar dari lastId), tanpa filter status
        $newOrders = Order::with('user')
            ->where('id', '>', $lastId)
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'new_count' => $newOrders->count(),
            'latest_id' => $latestId,
            'orders'    => $newOrders->map(fn($o) => [
                'order_number' => $o->order_number,
                'customer'     => $o->user->name ?? '-',
                'total'        => number_format($o->total_amount, 0, ',', '.'),
                'status'       => $o->status,
                'url'          => route('admin.orders.show', $o),
            ]),
        ]);
    }

    // List all orders with filters
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.book']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Search by order number or customer name/email
        if ($request->filled('search')) {
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
        $rules = [
            'status'          => 'required|in:pending,paid,processing,shipped,delivered,cancelled',
            'courier_name'    => 'nullable|string|max:100',
            'tracking_number' => 'nullable|string|max:100',
            'shipping_proof'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ];

        // Wajib isi resi saat status shipped
        if ($request->status === 'shipped') {
            $rules['courier_name']    = 'required|string|max:100';
            $rules['tracking_number'] = 'required|string|max:100';
        }

        $request->validate($rules);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        DB::beginTransaction();
        try {
            $updateData = ['status' => $newStatus];

            // Additional actions based on status
            if ($newStatus === Order::STATUS_SHIPPED && !$order->shipped_at) {
                $updateData['shipped_at']      = now();
                $updateData['courier_name']    = $request->courier_name;
                $updateData['tracking_number'] = $request->tracking_number;

                // Upload foto bukti pengiriman
                if ($request->hasFile('shipping_proof')) {
                    // Hapus foto lama jika ada
                    if ($order->shipping_proof) {
                        Storage::disk('public')->delete($order->shipping_proof);
                    }
                    $updateData['shipping_proof'] = $request->file('shipping_proof')
                        ->store('shipping-proofs', 'public');
                }
            }

            $order->update($updateData);

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
