<?php

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
            fn (AssertableJson $json) =>
            $json->has(
                'data',
                $interests->count(),
                fn (AssertableJson $json) =>
                $json->where('id', $interests->first()->id)
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