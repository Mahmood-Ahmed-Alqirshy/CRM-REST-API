<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Deal;

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
