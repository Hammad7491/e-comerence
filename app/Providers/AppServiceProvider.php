<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
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
        // Force HTTPS URLs in production so browsers don’t block mixed-content images
        if ($this->app->environment('production')) {
            // If you’re behind a proxy/CDN (Cloudflare/ELB), this still works as long as
            // TRUSTED_PROXIES is configured. Otherwise, also set APP_URL=https://your-domain
            URL::forceScheme('https');
            // Optionally: URL::forceRootUrl(config('app.url')); // if needed behind proxies
        }

        // Gate for admin-only routes
        Gate::define('admin', function ($user) {
            return ($user->role ?? null) === 'admin';
        });
    }
}
