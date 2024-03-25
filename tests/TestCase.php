<?php

namespace Tests;

use App\Models\Contact;
use App\Models\Deal;
use App\Models\Interest;
use App\Models\Location;
use App\Models\Tag;
use App\Models\User;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\This;

abstract class TestCase extends BaseTestCase
{
    public function makeToken() {
        $credentials = ['username' => 'Mahmoud', 'password' => 'password'];

        $response = $this->postJson('/api/login', $credentials, ['Accept' => 'application/json']);
        $this->token = $response->json()['token'];
    }

    public $token;
}
