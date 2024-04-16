<?php

namespace Database\Seeders;

use App\Models\Interest;
use App\Models\Location;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach (Interest::seeds() as $interest) {
            Interest::factory()->create($interest);
        }

        foreach (Tag::seeds() as $tag) {
            Tag::factory()->create($tag);
        }

        foreach (Location::seeds() as $location) {
            Location::factory()->create($location);
        }

        User::factory()->create(['username' => 'admin', 'password' => Hash::make('secret123')]);

        Artisan::call('facebook:refresh');
    }
}
