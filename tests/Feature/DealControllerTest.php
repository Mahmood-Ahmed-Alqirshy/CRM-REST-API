<?php

use App\Datasets\DealDatasets;
use App\Models\Deal;
use App\Models\Interest;
use App\Models\Tag;
use Database\Seeders\TestSeeder;
use Illuminate\Testing\Fluent\AssertableJson;

beforeEach(function () {
    $this->seed(TestSeeder::class);
    $this->makeToken();
});

it('can retrieve deals', function () {
    $deal = Deal::first();

    $this->getJson('/api/deals', ['Authorization' => "Bearer $this->token"])
        ->assertOK()
        ->assertJson(
            fn (AssertableJson $json) =>
            $json->has('meta')
                ->where('meta.last_page', 2)
                ->whereNot('meta.from', null)
                ->where('meta.total', 30)
                ->has('links')
                ->has(
                    'data',
                    15,
                    fn (AssertableJson $json) =>
                    $json->where('id', $deal->id)
                        ->where('heading', 'good pizza')
                        ->missing('tag_ids')
                        ->missing('interest_ids')
                        ->etc()
                )
        );
});

it('can retrieve deal', function () {
    $deal = Deal::first();
    $intresestIds = Interest::take(5)->pluck('id')->toArray();
    $tagIds = Tag::take(5)->pluck('id')->toArray();
    $deal->interests()->sync($intresestIds);
    $deal->tags()->sync($tagIds);

    $this->getJson("/api/deals/$deal->id", ['Authorization' => "Bearer $this->token"])
        ->assertOK()
        ->assertJson(
            fn (AssertableJson $json) =>
            $json->where('id', $deal->id)
                ->where('interest_ids', $intresestIds)
                ->where('tag_ids', $tagIds)
                ->etc()
        );
});

it("can't retrieve unexisting deal", function () {
    $this->getJson('/api/deals/999999', ['Authorization' => "Bearer $this->token"])
        ->assertNotFound();
});

it('can delete deal', function () {
    $deal = Deal::factory()->create();

    $this->deleteJson("/api/deals/$deal->id", [], ['Authorization' => "Bearer $this->token"])
        ->assertOK();

    expect(Deal::find($deal->id))->tobeNull();
});

it("can't delete unexisting deal", function () {
    $this->deleteJson('/api/deals/6579839', [], ['Authorization' => "Bearer $this->token"])
        ->assertNotFound();
});

it('can store deal', function () {
    $requests = DealDatasets::valid();

    foreach ($requests as $request) {
        // to make the deal that will be created have higher timestamp than the seeded ones
        // so it can be grabbed by Deal::latest()->first()
        sleep(1);

        $this->postJson('/api/deals', $request, ['Authorization' => "Bearer $this->token"])
            ->assertCreated();

        $deal = Deal::latest()->first()->append('interest_ids')->append('tag_ids')->toArray();
        expect($deal)->toMatchArray($request);
    }
});

it("can't store invalid deal", function () {
    $requests = DealDatasets::invalid();

    foreach ($requests as $request) {
        $this->postJson('/api/deals', $request['data'], ['Authorization' => "Bearer $this->token"])
            ->assertUnprocessable()
            ->assertInvalid($request['invalidFields'])
            ->assertJsonCount(count($request['invalidFields']), 'errors');
    }
});

it('can update deal', function () {
    $oldDeal = Deal::first();
    expect($oldDeal->heading)->toBe('good pizza');
    expect($oldDeal->interests()->pluck('id')->toArray())->toBeEmpty();
    expect($oldDeal->tags()->pluck('id')->toArray())->toBeEmpty();

    $request = DealDatasets::update();

    $this->putJson("/api/deals/$oldDeal->id", $request, ['Authorization' => "Bearer $this->token"])
        ->assertOK();

    $newDeal = Deal::find($oldDeal->id)->append('interest_ids')->append('tag_ids')->toArray();

    expect($newDeal)->toMatchArray($request);
});

it("can't update unexisting deal", function () {
    $this->putJson('/api/deals/6579839', [], ['Authorization' => "Bearer $this->token"])
        ->assertNotFound();
});

it('protect Deal endpoints', function () {
    $this->getJson('/api/deals')
       ->assertUnauthorized();
 
    $this->getJson('/api/deals/1')
       ->assertUnauthorized();
 
    $this->deleteJson('/api/deals/1')
       ->assertUnauthorized();
 
    $this->postJson('/api/deals')
       ->assertUnauthorized();
 
    $this->putJson('/api/deals/1')
       ->assertUnauthorized();
 });