<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // 1. Thêm dòng này

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
        // 2. Thêm đoạn code này để ép HTTPS trên Render
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}