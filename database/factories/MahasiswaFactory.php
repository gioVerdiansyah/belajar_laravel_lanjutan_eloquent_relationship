<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jurusan = ["Ilmu Komputer", "Teknik Informatika", "Sistem Informasi"];
        fake()->seed(407);
        return [
            'nim' => fake()->unique()->numerify('19######'),
            'nama' => fake('id_ID')->firstName() . " " . fake('id_ID')->lastName(),
            'jurusan' => fake()->randomElement($jurusan)
        ];
    }
}