<?php

namespace Database\Factories;

use App\Models\Deal;
use Illuminate\Database\Eloquent\Factories\Factory;

class DealFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Deal::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'heading' => $this->faker->text(),
            'description' => $this->faker->paragraph(),
            'datetime' => now()->addWeek(),
            'is_annual' => $this->faker->boolean(),
            'image' => $this->faker->imageUrl(),
        ];
    }
}
