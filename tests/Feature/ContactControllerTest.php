<?php

use App\Datasets\ContactDatasets;
use App\Models\Contact;
use App\Models\Interest;
use Database\Seeders\TestSeeder;
use Illuminate\Testing\Fluent\AssertableJson;

beforeEach(function () {
    $this->seed(TestSeeder::class);
    $this->makeToken();
});

it('can retrieve contacts', function () {
    $contacts = Contact::first();

    $this->getJson('/api/contacts', ['Authorization' => "Bearer $this->token"])
        ->assertOK()
        ->assertJson(
            fn (AssertableJson $json) => $json->has('meta')
                ->where('meta.last_page', 2)
                ->whereNot('meta.from', null)
                ->where('meta.total', 30)
                ->has('links')
                ->has(
                    'data',
                    15,
                    fn (AssertableJson $json) => $json->where('id', $contacts->id)
                        ->where('name', 'Mahmoud Ahmed')
                        ->has('location')
                        ->has('social_media_links')
                        ->missing('interest_ids')
                        ->etc()
                )
        );
});

it('can retrieve contact', function () {
    $contact = Contact::first();
    $intresestIds = Interest::take(5)->pluck('id')->toArray();
    $contact->interests()->sync($intresestIds);

    $this->getJson("/api/contacts/$contact->id", ['Authorization' => "Bearer $this->token"])
        ->assertOK()
        ->assertJson(
            fn (AssertableJson $json) => $json->where('id', $contact->id)
                ->where('interest_ids', $intresestIds)
                ->missing('location')
                ->has('social_media_links')
                ->etc()
        );
});

it("can't retrieve unexisting contact", function () {
    $this->getJson('/api/contacts/999999', ['Authorization' => "Bearer $this->token"])
        ->assertNotFound();
});

it('can delete contact', function () {
    $contact = Contact::factory()->create();

    $this->deleteJson("/api/contacts/$contact->id", [], ['Authorization' => "Bearer $this->token"])
        ->assertOK();

    expect(Contact::find($contact->id))->tobeNull();
});

it("can't delete unexisting contact", function () {
    $this->deleteJson('/api/contacts/6579839', [], ['Authorization' => "Bearer $this->token"])
        ->assertNotFound();
});

it('can store contact', function () {
    $requests = ContactDatasets::valid();

    foreach ($requests as $request) {
        // to make the Contact that will be created have higher timestamp than the seeded ones
        // so it can be grabbed by Contact::latest()->first()
        sleep(1);

        $this->postJson('/api/contacts', $request, ['Authorization' => "Bearer $this->token"])
            ->assertCreated();

        $contact = Contact::latest()->first()->append('interest_ids')->toArray();
        expect($contact)->toMatchArray($request);
    }
});

it("can't store invalid contact", function () {
    $requests = ContactDatasets::invalid();

    foreach ($requests as $request) {
        $this->postJson('/api/contacts', $request['data'], ['Authorization' => "Bearer $this->token"])
            ->assertUnprocessable()
            ->assertInvalid($request['invalidFields'])
            ->assertJsonCount(count($request['invalidFields']), 'errors');
    }
});

it('can update contact', function () {
    $oldContact = Contact::first();
    expect($oldContact->name)->toBe('Mahmoud Ahmed');
    expect($oldContact->interests()->pluck('id')->toArray())->toBeEmpty();

    $request = ContactDatasets::update();

    $this->putJson("/api/contacts/$oldContact->id", $request, ['Authorization' => "Bearer $this->token"])
        ->assertOK();

    $newContact = Contact::find($oldContact->id)->append('interest_ids')->toArray();

    expect($newContact)->toMatchArray($request);
});

it("can't update unexisting contact", function () {
    $this->putJson('/api/contacts/6579839', [], ['Authorization' => "Bearer $this->token"])
        ->assertNotFound();
});

it('protect Contact endpoints', function () {
    $this->getJson('/api/contacts')
        ->assertUnauthorized();

    $this->getJson('/api/contacts/1')
        ->assertUnauthorized();

    $this->deleteJson('/api/contacts/1')
        ->assertUnauthorized();

    $this->postJson('/api/contacts')
        ->assertUnauthorized();

    $this->putJson('/api/contacts/1')
        ->assertUnauthorized();
});
