<?php

namespace App\Providers;

use App\Models\Order;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        date_default_timezone_set(config('app.timezone'));

        // Inject data pesanan processing (baru masuk via Midtrans) ke semua view admin.*
        View::composer('admin.*', function ($view) {
            $pendingOrdersCount  = Order::where('status', Order::STATUS_PROCESSING)->count();
            $latestPendingOrders = Order::with('user')
                ->where('status', Order::STATUS_PROCESSING)
                ->latest()
                ->take(5)
                ->get();

            $view->with(compact('pendingOrdersCount', 'latestPendingOrders'));
        });
    }
}
