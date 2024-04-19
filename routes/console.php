<?php

use App\Jobs\SendEmailDealDispatcher;
use App\Models\Deal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    $start = Carbon::now()->format('Y-m-d H:i:00');
    $end = Carbon::now()->addMinute()->format('Y-m-d H:i:00');

    $deals = Deal::where('datetime', '>=', $start)
        ->where('datetime', '<=', $end)
        ->get();

    foreach ($deals as $deal) {
        SendEmailDealDispatcher::dispatch($deal);
    }
})->everyMinute();
