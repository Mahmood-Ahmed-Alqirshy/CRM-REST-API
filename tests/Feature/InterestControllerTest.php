<?php

use App\Models\Contact;
use App\Models\Deal;
use App\Models\Interest;
use Illuminate\Testing\Fluent\AssertableJson;

beforeEach(function () {
    $this->makeToken();
    Interest::factory(6)->create();
});

it('can retrieve interests', function () {
    $interests = Interest::all();
    $this->getJson('/api/interests', ['Authorization' => "Bearer $this->token"])
        ->assertOK()
        ->assertJson(
            fn (AssertableJson $json) => $json->has(
                'data',
                $interests->count(),
                fn (AssertableJson $json) => $json->where('id', $interests->first()->id)
                    ->has('name')
            )
                ->where('total', $interests->count())
        );
});

it('can store interest', function () {
    $request = ['name' => 'pizza'];

    // to make the interest that will be created have higher timestamp than the seeded ones
    // so it can be grabbed by Interest::latest()->first()
    sleep(1);

    $this->postJson('/api/interests', $request, ['Authorization' => "Bearer $this->token"])
        ->assertCreated();

    $newInterest = Interest::latest()->first()->toArray();
    expect($newInterest)->toMatchArray($request);

});

it("can't store invalid interest", function () {

    $request = ['name' => Interest::first()->name];
    $this->postJson('/api/interests', $request, ['Authorization' => "Bearer $this->token"])
        ->assertUnprocessable();

    $request = ['name' => str_repeat('ABCDEFGHIJ', 30)];
    $this->postJson('/api/interests', $request, ['Authorization' => "Bearer $this->token"])
        ->assertUnprocessable();
});

it('protect Interest endpoints', function () {
    $this->getJson('/api/interests')
        ->assertUnauthorized();

    $this->postJson('/api/interests')
        ->assertUnauthorized();
});

it('can delete interest', function () {
    // to make the next moduls the Model::latest()->first();
    sleep(1);

    $interest = Interest::factory()->create();

    $contact = Contact::factory()->create();
    $contact->interests()->sync([$interest->id]);

    $deal = Deal::factory()->create();
    $deal->interests()->sync([$interest->id]);

    expect(Contact::latest()->first()->interests()->count())->toBe(1);
    expect(Deal::latest()->first()->interests()->count())->toBe(1);

    $this->deleteJson("/api/interests/$interest->id", [], ['Authorization' => "Bearer $this->token"])
        ->assertOK();

    expect(Interest::find($interest->id))->toBeNull();
    expect(Contact::latest()->first()->interests()->count())->toBe(0);
    expect(Deal::latest()->first()->interests()->count())->toBe(0);
});

it("can't delete unexisting interest", function () {
    $this->deleteJson('/api/interests/6579839', [], ['Authorization' => "Bearer $this->token"])
        ->assertNotFound();
});
