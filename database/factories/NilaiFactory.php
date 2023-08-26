<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

Faker::create()->seed(407);

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Nilai>
 */
class NilaiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sem_1' => fake()->randomFloat(2, 2, 4),
            'sem_2' => fake()->randomFloat(2, 2, 4),
            'sem_3' => fake()->randomFloat(2, 2, 4),
            'mahasiswa_id' => fake()->unique()->randomDigit()
        ];
    }
}