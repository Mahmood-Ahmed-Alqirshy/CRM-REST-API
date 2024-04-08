<?php

use App\Models\Location;
use Illuminate\Testing\Fluent\AssertableJson;

beforeEach(function () {
    $this->makeToken();
    Location::factory(6)->create();
});

it('can retrieve locations', function () {
    $locations = Location::all();
    $this->getJson('/api/locations', ['Authorization' => "Bearer $this->token"])
        ->assertOK()
        ->assertJson(
            fn (AssertableJson $json) => $json->has(
                'data',
                $locations->count(),
                fn (AssertableJson $json) => $json->where('id', $locations->first()->id)
                    ->has('name')
            )
                ->where('total', $locations->count())
        );
});

it('can store location', function () {
    $request = ['name' => 'pizza'];

    // to make the location that will be created have higher timestamp than the seeded ones
    // so it can be grabbed by Location::latest()->first()
    sleep(1);

    $this->postJson('/api/locations', $request, ['Authorization' => "Bearer $this->token"])
        ->assertCreated();

    $newLocation = Location::latest()->first()->toArray();
    expect($newLocation)->toMatchArray($request);

});

it("can't store invalid location", function () {

    $request = ['name' => Location::first()->name];
    $this->postJson('/api/locations', $request, ['Authorization' => "Bearer $this->token"])
        ->assertUnprocessable();

    $request = ['name' => str_repeat('ABCDEFGHIJ', 30)];
    $this->postJson('/api/locations', $request, ['Authorization' => "Bearer $this->token"])
        ->assertUnprocessable();
});

it('protect Location endpoints', function () {
    $this->getJson('/api/locations')
        ->assertUnauthorized();

    $this->postJson('/api/locations')
        ->assertUnauthorized();
});
