<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

Faker::create()->seed(407);
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = [
            "Laskar Pelangi",
            "Negeri 5 Menara",
            "Bumi Manusia",
            "Tetralogi Buru",
            "Ronggeng Dukuh Paruk"
        ];
        return [
            'isbn' => fake()->unique()->isbn13(),
            'title' => fake()->unique()->randomElement($titles),
            'published' => fake()->dateTimeBetween("1990-01-01", "2014-01-01")
        ];
    }
}