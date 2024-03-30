<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function makeToken() {
        User::factory()->create(['username' => 'Mahmoud']);

        $response = $this->postJson('/api/login', $this->credentials, ['Accept' => 'application/json']);
        $this->token = $response->json()['token'];
    }

    public $token = '';

    public $credentials = ['username' => 'Mahmoud', 'password' => 'password'];
}
