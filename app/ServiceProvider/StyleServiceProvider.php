<?php

namespace App\ServiceProvider;

use App\core\style\StyleInterface;
use App\core\style\StyleRepository;
use Illuminate\Support\ServiceProvider;

class StyleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(StyleInterface::class, StyleRepository::class);
    }

    
}
