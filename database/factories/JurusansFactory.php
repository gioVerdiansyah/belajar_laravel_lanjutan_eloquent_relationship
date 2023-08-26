<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

Faker::create()->seed(407);

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jurusans>
 */
class JurusansFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->unique()->randomElement([
                "Rekayasa Perangkat Lunak",
                "Teknik Kendaraan Ringan",
                "Teknik Sepeda Motor",
                "Teknik Ototronik",
                "Agribisnis Pengolahan Hasil Pertanian"
            ]),
            'kepala_jurusan' => fake('id_ID')->name(),
            'daya_tampung' => fake()->randomElement([70, 90])
        ];
    }
}