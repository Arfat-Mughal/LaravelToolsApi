<?php

namespace App\Providers;

use App\Models\Site;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
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
        RateLimiter::for('contact-api', function (Request $request) {
            $siteKey = (string) $request->input('site_key', 'unknown-site');

            return Limit::perMinute(10)->by($siteKey.'|'.$request->ip());
        });
    }
}
