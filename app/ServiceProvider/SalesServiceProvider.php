<?php

namespace App\ServiceProvider;

use App\core\sales\SalesInterface;
use App\core\sales\SalesRepository;
use Illuminate\Support\ServiceProvider;

class SalesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SalesInterface::class, SalesRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
