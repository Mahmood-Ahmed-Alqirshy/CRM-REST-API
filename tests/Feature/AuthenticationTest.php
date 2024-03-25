<?php

use App\Models\User;


it('can login', function () {
   User::factory()->create(['username' => 'Mahmoud']);
   $credentials = ['username' => 'Mahmoud', 'password' => 'password'];

   $response = $this->postJson('/api/login', $credentials, ['Accept' => 'application/json']);
   $data = $response->json();
   $token = $data['token'];

   $response->assertOK();
   $response->assertJsonStructure(['token']);
});

it('rejects wrong credentials', function ($username, $password) {
   $credentials = ['username' => $username, 'password' => $password];

   $response = $this->postJson('/api/login', $credentials, ['Accept' => 'application/json']);
   $response->assertStatus(401);
})->with([
   ['Ahmed', 'password'],
   ['Mahmoud', '1234'],
   ['Ahmed', '1234']
]);


it('can logout', function () {
   User::factory()->create(['username' => 'Mahmoud']);
   $credentials = ['username' => 'Mahmoud', 'password' => 'password'];

   $response = $this->postJson('/api/login', $credentials, ['Accept' => 'application/json']);
   $data = $response->json();

   $response->assertOK();
   $response->assertJsonStructure(['token']);
   
   $response = $this->post('/api/logout', [], ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $data['token']]);
   
   $response->assertOK();
});

it("can't logout without token", function () {
   $response = $this->post('/api/logout', [], ['Accept' => 'application/json']);
   $response->assertStatus(401);
});

it('protect contact endpoints', function() {
   $response = $this->get('/api/contacts', ['Accept' => 'application/json']);
   $response->assertStatus(401);

   $response = $this->get('/api/contacts/1', ['Accept' => 'application/json']);
   $response->assertStatus(401);

   $response = $this->deleteJson('/api/contacts/1', [], ['Accept' => 'application/json']);
   $response->assertStatus(401);

   $response = $this->postJson('/api/contacts', [] , ['Accept' => 'application/json']);
   $response->assertStatus(401);

   $response = $this->putJson('/api/contacts/1' , [] , ['Accept' => 'application/json']);
   $response->assertStatus(401);

});