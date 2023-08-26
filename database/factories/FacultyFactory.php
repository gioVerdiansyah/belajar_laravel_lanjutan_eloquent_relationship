<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

Faker::create()->seed(400);
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faculty>
 */
class FacultyFactory extends Factory
{
    protected $faculties = [
        "Fakultas Ilmu Komputer",
        "Fakultas Teknik Informatika",
        "Fakultas Sistem Informasi",
        "Fakultas Hukum",
        "Fakultas Fakultas MIPA"
    ];
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement($this->faculties),
            'dean' => fake('id_ID')->name()
        ];
    }
}