<?php

namespace App\ServiceProvider;

use App\core\artist\ArtistInterface;
use App\core\artist\ArtistRepository;
use Illuminate\Support\ServiceProvider;

class ArtistServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ArtistInterface::class, ArtistRepository::class);
    }

    
}
