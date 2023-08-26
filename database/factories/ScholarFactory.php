<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

Faker::create()->seed(400);
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Scholar>
 */
class ScholarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sid' => fake()->numerify('########'),
            'name' => fake('id_ID')->firstName() . " " . fake('id_ID')->lastName(),
            'departement_id' => fake()->numberBetween(1, 5)
        ];
    }
}