<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->paragraph(),
            'target' => fake()->name(),
            'type' => fake()->name(),
            'startDate' => now(),
            'endDate' => now(),
            'coast' => 12,
            'score' => fake()->numberBetween(1,100),
            'projectOwner' => fake()->name(),
           
        ];
    }
}
