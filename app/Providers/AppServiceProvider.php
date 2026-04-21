<?php

namespace App\Providers;

use Illuminate\Database\QueryException;
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
        // Handle database connection errors gracefully during provisioning
        try {
            \Illuminate\Support\Facades\DB::connection()->getPdo();
        } catch (QueryException $e) {
            // Database not yet available - safe to continue during provisioning
            \Illuminate\Support\Facades\Log::warning('Database connection failed during bootstrap', [
                'error' => $e->getMessage()
            ]);
        }
    }
}
