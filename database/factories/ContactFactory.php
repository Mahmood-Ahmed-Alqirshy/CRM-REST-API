<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'phone' => $this->faker->numberBetween(700000000, 799999999),
            'social_media_links' => '{}',
            'email' => $this->faker->email(),
            'location_id' => Location::factory()->create(),
            'birth_date' => $this->faker->dateTimeBetween(now()->subDecade(3), now()->subDecade(1)),
        ];
    }
}
