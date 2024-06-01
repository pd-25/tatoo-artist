<?php

namespace App\ServiceProvider;

use App\core\artwork\ArtworkInterface;
use App\core\artwork\ArtworkRepository;
use Illuminate\Support\ServiceProvider;

class ArtworkServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ArtworkInterface::class, ArtworkRepository::class);
    }

    
}
