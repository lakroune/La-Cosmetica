<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('manage-categories', function ($user) {
            return $user->isWorker();
        });
        Gate::define('manage-products', function ($user) {
            return $user->isAdmin();
        });
        Gate::define('manage-orders', function ($user) {
            return $user->isWorker();
        });
        Gate::define('view-order', function ($user, $order) {
            return $order->isMine($user) || $user->isAdmin();
        });

        Gate::define('cancel-order', function ($user, $order) {
            return $order->isMine($user) && $user->isClient() && $order->status === 'pending';
        });
    }
}
