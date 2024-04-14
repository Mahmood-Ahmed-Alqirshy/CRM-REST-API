<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Deal;
use App\Models\Interest;
use App\Models\Location;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Tag::factory(5)->create();

        Location::factory(5)->create();

        Interest::factory(5)->create();

        User::factory(1)->create();

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
            'email' => 'ddd@ddd.com',
        ]);

        // i used for to create unique phone and email for every user
        // because unique() function in faker do not work properly
        for ($i = 0; $i < 29; $i++) {
            Contact::factory()->create(
                [
                    'phone' => str_pad($i, 9, 0, STR_PAD_LEFT),
                    'email' => "mahmoud$i@example.com",
                ]
            );
        }
    }
}
