<?php

use App\Datasets\ContactDatasets;
use App\Models\Contact;
use App\Models\Interest;
use App\Models\Location;
use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Support\Facades\Artisan;


beforeEach(function () {
    $this->seed(TestSeeder::class);
    $this->makeToken();

});

it('can retrieve contacts', function () {
    $contacts = Contact::all();

    $response = $this->get('/api/contacts' , ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $this->token]);
    $response->assertOK();
    $data = json_decode($response->content());

    expect($data->total)->toBe(15);
    expect($data->total_pages)->toBe(2);

    for ($i = 0; $i < 5; $i++) {
        expect($data->data[$i]->name)
            ->toBe($contacts[$i]->name);
    }
});

it('can retrieve contacts pages', function () {
    Contact::factory(5)->create();
    $contacts = Contact::all();
    
    $page = 3;

    $response = $this->get('/api/contacts?page=' . $page , ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $this->token]);
    $response->assertOK();
    $data = json_decode($response->content());

    expect($data->total)->toBe(5);
    expect($data->total_pages)->toBe(3);

    for ($i = 0; $i < 5; $i++) {
        expect($data->data[$i]->name)
            ->toBe($contacts[$i + (($page-1)*15)]->name);
    }
});

it("it reject invalid page number", function () {
    Contact::factory(15)->create();
    
    $page = 'mmm';

    $response = $this->get('/api/contacts?page=' . $page , ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $this->token]);
 
    $response->assertStatus(422);
});

it('can return empty respone when exceed number of pages', function () {
    $page = 100;

    $response = $this->get('/api/contacts?page=' . $page , ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $this->token]);
    $response->assertOK();
    $data = json_decode($response->content());

    expect($data->total)->toBe(0);
    expect($data->total_pages)->toBe(2);
});

it('can retrieve contact', function () {
    $contact = Contact::first();
    
    $interests = Interest::take(5)->get();
    $intresestIds = $interests->pluck('id')->toArray();
    $contact->interests()->sync($intresestIds);

    $response = $this->get('/api/contacts/' . $contact->id, ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $this->token]);
    $response->assertOK();
    $data = json_decode($response->content(), true);
    
    expect($data)->toMatchArray($contact->append('interests')->toArray());
    expect($contact->interests()->pluck('id')->toArray())->toEqualCanonicalizing($data['interests']);
});

it("can't retrieve unexisting contact", function () {
    $response = $this->get('/api/contacts/6579839', ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $this->token]);
    $response->assertStatus(404);
});

it('can delete contact', function () {
    $contact = Contact::factory()->create();

    $response = $this->deleteJson('/api/contacts/' . $contact->id, [], ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $this->token]);

    $response->assertOK();

    expect(Contact::find($contact->id))->tobeNull();
});

it("can't delete unexisting contact", function () {
    $response = $this->deleteJson('/api/contacts/6579839', [] , ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $this->token]);
    $response->assertStatus(404);
});

it('can store contact', function () {
    $location = Location::first();
    $interests = Interest::all();
    $request = [
        'name' => 'Mahmoud Ahmed',
        'phone' => '737514829',
        'facebook_id' => '12831093',
        'instagram_id' => 'mahmoodahmed404',
        'email' => 'mahmoud@ahmed.com',
        'location_id' => $location->id,
        'birthday' => now()->subDecade(2)->format('Y-m-d'),
        'interests' => $interests->take(3)->pluck('id')->toArray(),
    ];

    sleep(1);

    $response = $this->postJson('/api/contacts', $request, ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $this->token]);
    
    $response->assertOK();

    $contact = Contact::latest()->first()->append('interests')->makeHidden(['created_at', 'updated_at', 'id'])->toArray();
    
    expect($contact)->toMatchArray($request);
});

it("can't store invalid contact", function () {
    $dataset = ContactDatasets::invalid();

    foreach($dataset as $request) {
        $response = $this->postJson('/api/contacts', $request['data'], ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $this->token]);
        $response->assertStatus(422);
        
        $errors = json_decode($response->content(),true)['errors'];
        expect($errors)->toHaveLength(count($request['invalidFields']));
        expect($errors)->toHaveKeys($request['invalidFields']);
    }
    
});

it('can update contact', function () {
    $oldContact = Contact::factory()->create();

    $location = Location::factory()->create();
    $interests = Interest::factory(5)->create();

    $oldContact->interests()->sync($interests->skip(3)->take(2)->pluck('id')->toArray());

    $request = [
        'name' => 'Ahmed Mahmoud',
        'phone' => '777514829',
        'facebook_id' => '12531093',
        'instagram_id' => 'mahmoudahmed404',
        'email' => 'mahmood@ahmed.com',
        'location_id' => $location->id,
        'birthday' => now()->subDecade(2)->format('Y-m-d'),
        'interests' => $interests->take(3)->pluck('id')->toArray(),
    ];

    $response = $this->putJson('/api/contacts/' . $oldContact->id, $request, ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $this->token]);

    $response->assertOK();

    $contact = Contact::find($oldContact->id)->append('interests')->makeHidden(['created_at', 'updated_at', 'id'])->toArray();

    expect($contact)->toMatchArray($request);
});

it("can't update unexisting contact", function () {
    $response = $this->putJson('/api/contacts/6579839', [] , ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $this->token]);
    $response->assertStatus(404);
});
