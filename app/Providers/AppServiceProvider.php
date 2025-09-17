<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Event;
use App\Events\ProductColorsSynced;
use App\Events\ProductCaracteristicasSynced;
use App\Listeners\LogProductColorsSynced;
use App\Listeners\LogProductCaracteristicasSynced;

use Illuminate\Support\Facades\URL;


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

        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        Route::aliasMiddleware('admin', AdminMiddleware::class);
        Route::aliasMiddleware('user', UserMiddleware::class);

        Event::listen(
            ProductColorsSynced::class,
            [LogProductColorsSynced::class, 'handle']
        );

        Event::listen(
            ProductCaracteristicasSynced::class,
            [LogProductCaracteristicasSynced::class, 'handle']
        );
    }
}
