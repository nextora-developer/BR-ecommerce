<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\PopupBanner;
use Illuminate\Support\Facades\View;
use App\Models\Order;
use App\Observers\OrderObserver;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            try {
                $popupBanner = PopupBanner::where('is_active', true)->latest()->first();
            } catch (\Throwable $e) {
                $popupBanner = null;
                Log::error('PopupBanner load failed', ['error' => $e->getMessage()]);
            }

            $view->with('popupBanner', $popupBanner);
        });

        Order::observe(OrderObserver::class);
    }
}
