<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Deal;
use App\Models\Interest;
use App\Models\Location;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::factory(5)->create();
        
        Location::factory(5)->create();

        Interest::factory(5)->create();

        Deal::factory()->create([
            'heading' => 'good pizza',
            'description' => 'it is really good',
            'datetime' => now()->addWeek(3),
            'is_annual' => false,
            'image' => 'pizza.png',
        ]);
        Deal::factory(29)->create();

        Contact::factory()->create([
            'name' => 'Mahmoud Ahmed',
            'phone' => '123456789',
            'social_media_links' => '{ "facebook": "https://www.facebook.com/123456", "instagram": "https://www.instagram.com/example" }',
            'email' => 'ddd@ddd.com'
        ]);
        Contact::factory(29)->create();
    }
}
