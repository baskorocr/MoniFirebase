<?php

namespace App\Providers;
use Inertia\Inertia;

use Illuminate\Support\Facades\Vite;
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
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }
        
        Vite::prefetch(concurrency: 3);
        Inertia::share([
            'flash' => function () {
                return [
                    'error' => session('error'),
                    'status' => session('status'),
                ];
            },
        ]);
    }
}