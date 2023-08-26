<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

Faker::create()->seed(400);
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Departement>
 */
class DepartementFactory extends Factory
{
    protected $depart = [
        "Teknik Informatika",
        "Sistem Informasi",
        "Hukum",
        "Matematika",
        'Statistika'
    ];

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement($this->depart),
            'departement_head' => fake('id_ID')->name(),
            'capacity' => fake()->randomElement([90, 120, 160, 200]),
            'faculty_id' => fake()->numberBetween(1, 5)
        ];
    }
}