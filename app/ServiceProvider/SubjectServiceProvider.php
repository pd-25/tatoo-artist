<?php

namespace App\ServiceProvider;

use App\core\subject\SubjectInterface;
use App\core\subject\SubjectRepository;
use Illuminate\Support\ServiceProvider;

class SubjectServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SubjectInterface::class, SubjectRepository::class);
    }

    
}
