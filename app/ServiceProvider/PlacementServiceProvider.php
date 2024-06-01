<?php

namespace App\ServiceProvider;

use App\core\placement\PlacementInterface;
use App\core\placement\PlacementRepository;
use Illuminate\Support\ServiceProvider;

class PlacementServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PlacementInterface::class, PlacementRepository::class);
    }

    
}
