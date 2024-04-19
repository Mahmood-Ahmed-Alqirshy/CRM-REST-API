<?php

use App\Models\Deal;
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

it('can delete tag', function () {
    // to make the next moduls the Model::latest()->first();
    sleep(1);

    $tag = Tag::factory()->create();

    $deal = Deal::factory()->create();
    $deal->tags()->sync([$tag->id]);

    expect(Deal::latest()->first()->tags()->count())->toBe(1);

    $this->deleteJson("/api/tags/$tag->id", [], ['Authorization' => "Bearer $this->token"])
        ->assertOK();

    expect(Tag::find($tag->id))->toBeNull();
    expect(Deal::latest()->first()->tags()->count())->toBe(0);
});

it("can't delete unexisting tag", function () {
    $this->deleteJson('/api/tags/6579839', [], ['Authorization' => "Bearer $this->token"])
        ->assertNotFound();
});
