<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote');


Artisan::command('app:subscription-cron', function () {
    // Your logic here
    // Example:
    Log::info('Subscription cron ran successfully at ' . now());

    // You can run Eloquent, services, etc.
    // Example: \App\Models\User::where('active', 1)->update(['checked' => true]);

    $this->info('Subscription cron executed successfully!');
})->purpose('Runs the daily subscription renewal process');

