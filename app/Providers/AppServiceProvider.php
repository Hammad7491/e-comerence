<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;   // 👈 add this

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
        // 👇 Define an "admin" Gate used by your routes middleware: can:admin
        Gate::define('admin', function ($user) {
            // Adjust to your schema. From your AuthController you’re using a `role` column.
            return ($user->role ?? null) === 'admin';
        });
    }
}
