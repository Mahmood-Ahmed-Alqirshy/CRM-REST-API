<?php

namespace App\Http\Controllers;

use App\Http\Requests\DealRequest;
use App\Http\Resources\DealResource;
use App\Models\Deal;

class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DealResource::collection(Deal::paginate(15));
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
