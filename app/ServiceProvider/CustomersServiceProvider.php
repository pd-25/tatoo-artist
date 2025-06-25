<?php

namespace App\ServiceProvider;

use App\core\customers\CustomersInterface;
use App\core\customers\CustomersRepository;
use Illuminate\Support\ServiceProvider;

class CustomersServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CustomersInterface::class, CustomersRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
