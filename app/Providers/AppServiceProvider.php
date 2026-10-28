<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        config(['app.timezone' => 'Asia/Jakarta']);
        date_default_timezone_set('Asia/Jakarta');
        \Carbon\Carbon::setLocale('id');

        if (app()->environment('production') || request()->header('x-forwarded-proto') === 'https' || request()->isSecure()) {
            URL::forceScheme('https');
        }
    }
}
