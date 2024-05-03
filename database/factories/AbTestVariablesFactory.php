<?php

namespace Database\Factories;

use App\Models\AbTests;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\AbTestVariables>
 */
class AbTestVariablesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->userName,
            'abTestId' => AbTests::factory(),
            'ratio' => fake()->randomFloat(1, 0, 5)
        ];
    }
}
