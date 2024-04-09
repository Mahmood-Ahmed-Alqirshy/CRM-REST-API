<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class RefreshPageToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'facebook:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh Facebook page access token';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Http::withQueryParameters([
            'access_token' => config('facebook.user_access_token'),
        ])->throw()->get('https://graph.facebook.com/v19.0/me/accounts')->json();

        $access_token = Arr::get($response, 'data.0.access_token');

        Cache::put('page_access_token', $access_token, 86400); // one day
    }
}
