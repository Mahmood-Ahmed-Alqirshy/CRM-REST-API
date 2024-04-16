<?php

use App\APINotifications\Messenger;
use App\Models\Contact;
use App\Models\Deal;
use App\Notifications\DealOn;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    $start = Carbon::now()->format('Y-m-d H:i:00');
    $end = Carbon::now()->addMinute()->format('Y-m-d H:i:00');

    $deals = Deal::where('datetime', '>=', $start)
        ->where('datetime', '<=', $end)
        ->get();

    foreach ($deals as $deal) {
        foreach (Contact::getByDeal($deal) as $contact) {
            $contact->notify(new DealOn($deal));
        }
        Messenger::send($deal);
    }
})->everyMinute();
