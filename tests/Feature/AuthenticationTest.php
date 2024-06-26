<?php

beforeEach(function () {
    $this->makeToken();
});

it('can login', function () {
    $this->postJson('/api/login', $this->credentials)
        ->assertOK()
        ->assertJsonStructure(['token']);
});

it('rejects wrong credentials', function ($username, $password) {
    $invalidCredentials = ['username' => $username, 'password' => $password];

    $this->postJson('/api/login', $invalidCredentials)
        ->assertUnauthorized();

})->with([
    ['Ahmed', 'password'],
    ['Mahmoud', '1234'],
    ['Ahmed', '1234'],
]);

it('rejects incomplete credentials', function ($credentials) {

    $this->postJson('/api/login', $credentials)
        ->assertUnprocessable();

})->with([
    [['username' => 'Mahmoud']],
    [['password' => 'password']],
    [[]],
]);

it('can logout', function () {
    $this->postJson('/api/logout', [], ['Authorization' => "Bearer $this->token"])
        ->assertOK();
});

it("can't logout without token", function () {
    $this->postJson('/api/logout')
        ->assertUnauthorized();
});
