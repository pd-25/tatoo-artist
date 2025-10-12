<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SubscriptionCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:subscription-cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This cron will add the daily subscription, will run every night 12AM';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = route('subscriptioncron');
    
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Set timeout (optional)

        // Execute the cURL request
        $response = curl_exec($ch);
       
        // Check for errors
        if (curl_errno($ch)) {
            $this->error('cURL error: ' . curl_error($ch));
        }

        // Close cURL session
        curl_close($ch);
        // Return the data (or do something with it)
        // dd($response);
        return $response;
    }
}
