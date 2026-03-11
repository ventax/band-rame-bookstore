<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ── Basic stats ──────────────────────────────────────────────
        // Revenue: orders with payment_status = 'paid' (set by Midtrans callback/finish)
        $totalRevenue = Order::where('payment_status', Order::PAYMENT_PAID)
            ->where('status', '!=', Order::STATUS_CANCELLED)
            ->sum('grand_total');

        $stats = [
            'total_books'       => Book::count(),
            'total_categories'  => Category::count(),
            'total_orders'      => Order::count(),
            'total_users'       => User::where('role', 'customer')->count(),
            'pending_orders'    => Order::where('status', Order::STATUS_PROCESSING)->count(),
            'total_revenue'     => $totalRevenue,
            // This month
            'revenue_this_month' => Order::where('payment_status', Order::PAYMENT_PAID)
                ->where('status', '!=', Order::STATUS_CANCELLED)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('grand_total'),
            'orders_this_month' => Order::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            // Delivered (completed) orders
            'delivered_orders'  => Order::where('status', Order::STATUS_DELIVERED)->count(),
        ];

        // ── Revenue last 7 days (for sparkline / bar chart) ──────────
        $revenueChart = collect(range(6, 0))->map(function ($daysAgo) {
            $date = now()->subDays($daysAgo);
            $rev  = Order::where('payment_status', Order::PAYMENT_PAID)
                ->where('status', '!=', Order::STATUS_CANCELLED)
                ->whereDate('created_at', $date)
                ->sum('grand_total');
            return [
                'label'   => $date->format('d/m'),
                'revenue' => (float) $rev,
                'orders'  => Order::whereDate('created_at', $date)->count(),
            ];
        });

        // ── Revenue last 6 months ────────────────────────────────────
        $revenueMonthly = collect(range(5, 0))->map(function ($monthsAgo) {
            $date = now()->subMonths($monthsAgo);
            $rev  = Order::where('payment_status', Order::PAYMENT_PAID)
                ->where('status', '!=', Order::STATUS_CANCELLED)
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('grand_total');
            return [
                'label'   => $date->format('M Y'),
                'revenue' => (float) $rev,
            ];
        });

        // ── Top 5 best-selling books ─────────────────────────────────
        $topBooks = OrderItem::select(
            'book_id',
            DB::raw('SUM(quantity) as total_sold'),
            DB::raw('SUM(quantity * price) as total_revenue')
        )
            ->with('book.category')
            ->groupBy('book_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // ── Order status breakdown ───────────────────────────────────
        $orderStatusBreakdown = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        // ── Top categories by revenue ────────────────────────────────
        $topCategories = OrderItem::select(
            'categories.id as category_id',
            'categories.name as category_name',
            DB::raw('SUM(order_items.quantity) as total_sold'),
            DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue')
        )
            ->join('books', 'order_items.book_id', '=', 'books.id')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_revenue')
            ->take(5)
            ->get()
            ->map(fn($item) => [
                'name'    => $item->category_name,
                'sold'    => $item->total_sold,
                'revenue' => $item->total_revenue,
            ]);

        // ── Recent orders ────────────────────────────────────────────
        $recent_orders = Order::with(['user', 'items.book'])
            ->latest()
            ->take(7)
            ->get();

        // ── Low stock books ──────────────────────────────────────────
        $low_stock_books = Book::where('stock', '<=', 10)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        // ── New customers (last 30 days) ─────────────────────────────
        $newCustomers = User::where('role', 'customer')
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        return view('admin.dashboard', compact(
            'stats',
            'recent_orders',
            'low_stock_books',
            'revenueChart',
            'revenueMonthly',
            'topBooks',
            'orderStatusBreakdown',
            'topCategories',
            'newCustomers'
        ));
    }
}
