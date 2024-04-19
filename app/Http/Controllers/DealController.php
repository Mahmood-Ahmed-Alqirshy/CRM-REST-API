<?php

namespace App\Http\Controllers;

use App\APINotifications\Messenger;
use App\Http\Requests\DealRequest;
use App\Http\Resources\DealResource;
use App\Jobs\SendEmailDeal;
use App\Jobs\SendEmailDealDispatcher;
use App\Jobs\SendMessengerDealDispatcher;
// use App\Mail\DealOn;
use App\Models\Contact;
use App\Models\Deal;
use App\Notifications\DealOn;
use Carbon\Carbon;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;

class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DealResource::collection(Deal::with('interests')->with('tags')->paginate(15));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DealRequest $request)
    {
        $validated = $request->safe()->except(['interest_ids', 'tag_ids']);
        $interests = $request->safe()->only(['interest_ids'])['interest_ids'];
        $tags = $request->safe()->only(['tag_ids'])['tag_ids'];

        $deal = Deal::create($validated);
        $deal->interests()->sync($interests);
        $deal->tags()->sync($tags);

        //send notification if datetime is in the past
        $datetime = new Carbon($deal->datetime);
        if ($datetime->lessThan(now()->startOfMinute()->addMinute())) {
            SendEmailDealDispatcher::dispatch($deal);
        }

        return response()->json(['massage' => 'The request has succeeded.'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Deal $deal)
    {
        return new DealResource($deal->load('interests')->load('tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DealRequest $request, Deal $deal)
    {
        $validated = $request->safe()->except(['interest_ids', 'tag_ids']);
        $interests = $request->safe()->only(['interest_ids'])['interest_ids'];
        $tags = $request->safe()->only(['tag_ids'])['tag_ids'];

        $deal->update($validated);
        $deal->interests()->sync($interests);
        $deal->tags()->sync($tags);

        return response()->json(['massage' => 'The request has succeeded.', 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deal $deal)
    {
        $deal->delete();

        return response()->json(['massage' => 'The request has succeeded.', 200]);
    }
}
