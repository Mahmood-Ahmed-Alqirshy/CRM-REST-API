<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Contact;
use App\Models\Location;
use Carbon\Carbon;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'phone' => null,
            'social_media_links' => '{}',
            'email' => null,
            'location_id' => Location::factory()->create(),
            'birth_date' => $this->faker->dateTimeBetween(now()->subDecade(3),now()->subDecade(1)),
        ];
    }
}
