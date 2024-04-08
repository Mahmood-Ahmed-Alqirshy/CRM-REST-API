<?php

use App\Models\Tag;
use Illuminate\Testing\Fluent\AssertableJson;

beforeEach(function () {
    $this->makeToken();
    Tag::factory(6)->create();
});

it('can retrieve tags', function () {
    $tags = Tag::all();
    $this->getJson('/api/tags', ['Authorization' => "Bearer $this->token"])
        ->assertOK()
        ->assertJson(
            fn (AssertableJson $json) => $json->has(
                'data',
                $tags->count(),
                fn (AssertableJson $json) => $json->where('id', $tags->first()->id)
                    ->has('name')
            )
                ->where('total', $tags->count())
        );
});

it('can store tag', function () {
    $request = ['name' => 'pizza'];

    // to make the tag that will be created have higher timestamp than the seeded ones
    // so it can be grabbed by Tag::latest()->first()
    sleep(1);

    $this->postJson('/api/tags', $request, ['Authorization' => "Bearer $this->token"])
        ->assertCreated();

    $newTag = Tag::latest()->first()->toArray();
    expect($newTag)->toMatchArray($request);

});

it("can't store invalid tag", function () {

    $request = ['name' => Tag::first()->name];
    $this->postJson('/api/tags', $request, ['Authorization' => "Bearer $this->token"])
        ->assertUnprocessable();

    $request = ['name' => str_repeat('ABCDEFGHIJ', 30)];
    $this->postJson('/api/tags', $request, ['Authorization' => "Bearer $this->token"])
        ->assertUnprocessable();
});

it('protect Tag endpoints', function () {
    $this->getJson('/api/tags')
        ->assertUnauthorized();

    $this->postJson('/api/tags')
        ->assertUnauthorized();
});
