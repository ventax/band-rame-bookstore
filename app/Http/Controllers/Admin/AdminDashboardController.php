<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $dashboardStartAt = env('DASHBOARD_START_AT');
        $dashboardStartDate = null;

        if (!empty($dashboardStartAt)) {
            try {
                $dashboardStartDate = Carbon::parse($dashboardStartAt)->startOfDay();
            } catch (\Exception $e) {
                $dashboardStartDate = null;
            }
        }

        $applyOrderCutoff = function ($query) use ($dashboardStartDate) {
            if ($dashboardStartDate) {
                $query->where('created_at', '>=', $dashboardStartDate);
            }

            return $query;
        };

        // ── Basic stats ──────────────────────────────────────────────
        // Revenue: orders with payment_status = 'paid' (set by Midtrans callback/finish)
        $totalRevenue = $applyOrderCutoff(Order::query())
            ->where('payment_status', Order::PAYMENT_PAID)
            ->where('status', '!=', Order::STATUS_CANCELLED)
            ->sum('grand_total');

        $customerQuery = User::where('role', 'customer');
        if ($dashboardStartDate) {
            $customerQuery->where('created_at', '>=', $dashboardStartDate);
        }

        $ordersThisMonthQuery = $applyOrderCutoff(Order::query())
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);

        $stats = [
            'total_books'       => Book::count(),
            'total_categories'  => Category::count(),
            'total_orders'      => $applyOrderCutoff(Order::query())->count(),
            'total_users'       => (clone $customerQuery)->count(),
            'pending_orders'    => $applyOrderCutoff(Order::query())->where('status', Order::STATUS_PROCESSING)->count(),
            'total_revenue'     => $totalRevenue,
            // This month
            'revenue_this_month' => $applyOrderCutoff(Order::query())
                ->where('payment_status', Order::PAYMENT_PAID)
                ->where('status', '!=', Order::STATUS_CANCELLED)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('grand_total'),
            'orders_this_month' => $ordersThisMonthQuery->count(),
            // Delivered (completed) orders
            'delivered_orders'  => $applyOrderCutoff(Order::query())->where('status', Order::STATUS_DELIVERED)->count(),
        ];

        // ── Revenue last 7 days (for sparkline / bar chart) ──────────
        $revenueChart = collect(range(6, 0))->map(function ($daysAgo) use ($applyOrderCutoff) {
            $date = now()->subDays($daysAgo);
            $rev  = $applyOrderCutoff(Order::query())
                ->where('payment_status', Order::PAYMENT_PAID)
                ->where('status', '!=', Order::STATUS_CANCELLED)
                ->whereDate('created_at', $date)
                ->sum('grand_total');

            return [
                'label'   => $date->format('d/m'),
                'revenue' => (float) $rev,
                'orders'  => $applyOrderCutoff(Order::query())->whereDate('created_at', $date)->count(),
            ];
        });

        // ── Revenue last 6 months ────────────────────────────────────
        $revenueMonthly = collect(range(5, 0))->map(function ($monthsAgo) use ($applyOrderCutoff) {
            $date = now()->subMonths($monthsAgo);
            $rev = $applyOrderCutoff(Order::query())
                ->where('payment_status', Order::PAYMENT_PAID)
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
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->with('book.category')
            ->when($dashboardStartDate, fn($q) => $q->where('orders.created_at', '>=', $dashboardStartDate))
            ->groupBy('book_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // ── Order status breakdown ───────────────────────────────────
        $orderStatusBreakdown = $applyOrderCutoff(Order::query())
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        // ── Top categories by revenue ────────────────────────────────
        $topCategories = OrderItem::select(
            'categories.id as category_id',
            'categories.name as category_name',
            DB::raw('SUM(order_items.quantity) as total_sold'),
            DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue')
        )
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('books', 'order_items.book_id', '=', 'books.id')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->when($dashboardStartDate, fn($q) => $q->where('orders.created_at', '>=', $dashboardStartDate))
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
            ->when($dashboardStartDate, fn($q) => $q->where('created_at', '>=', $dashboardStartDate))
            ->latest()
            ->take(7)
            ->get();

        // ── Low stock books ──────────────────────────────────────────
        $low_stock_books = Book::where('stock', '<=', 10)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        // ── New customers (last 30 days) ─────────────────────────────
        $newCustomersSince = now()->subDays(30);
        if ($dashboardStartDate && $dashboardStartDate->greaterThan($newCustomersSince)) {
            $newCustomersSince = $dashboardStartDate;
        }

        $newCustomers = User::where('role', 'customer')
            ->where('created_at', '>=', $newCustomersSince)
            ->count();

        $midtransMode = config('services.midtrans.environment', 'sandbox');

        return view('admin.dashboard', compact(
            'stats',
            'recent_orders',
            'low_stock_books',
            'revenueChart',
            'revenueMonthly',
            'topBooks',
            'orderStatusBreakdown',
            'topCategories',
            'newCustomers',
            'midtransMode'
        ));
    }
}
