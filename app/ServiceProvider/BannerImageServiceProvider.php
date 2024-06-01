<?php

namespace App\ServiceProvider;

use App\core\banner\BannerInterface;
use App\core\banner\BannerRepository;
use Illuminate\Support\ServiceProvider;

class BannerImageServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BannerInterface::class, BannerRepository::class);
    }

    
}
