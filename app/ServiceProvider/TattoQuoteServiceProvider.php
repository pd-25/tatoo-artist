<?php

namespace App\ServiceProvider;

use App\core\customers\TattoQuoteInterface;
use App\core\customers\TattoQuoteRepository;
use Illuminate\Support\ServiceProvider;

class TattoQuoteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TattoQuoteInterface::class, TattoQuoteRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}