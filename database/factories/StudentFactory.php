<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

// Faker::create()->seed(407);

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nis' => fake()->unique()->numerify('35##/6##.0##'),
            'nama' => fake('id_ID')->firstName() . " " . fake('id_ID')->lastName(),
            'jurusan' => fake()->randomElement([
                "Rekayasa Perangkat Lunak",
                "Teknik Kendaraan Ringan",
                "Teknik Sepeda Motor",
                "Teknik Ototronik",
                "Agribisnis Pengolahan Hasil Pertanian"
            ])
        ];
    }
}