<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Student::all() as $student) {
            $sem_1 = fake()->randomFloat(2, 45, 90);
            $sem_2 = fake()->randomFloat(2, 45, 90);
            $sem_3 = fake()->randomFloat(2, 45, 90);
            $sum = ($sem_1 + $sem_2 + $sem_3) / 3;

            $grade = '';
            switch (true) {
                case $sum >= 85:
                    $grade = 'A';
                    break;
                case $sum >= 75:
                    $grade = 'B';
                    break;
                case $sum >= 70:
                    $grade = 'C';
                    break;
                case $sum >= 65:
                    $grade = 'D';
                    break;
                case $sum >= 50:
                    $grade = 'E';
                    break;
                default:
                    $grade = 'F';
                    break;
            }
            Grade::create([
                'sem_1' => $sem_1,
                'sem_2' => $sem_2,
                'sem_3' => $sem_3,
                'grade' => $grade,
                'student_id' => $student->id
            ]);
        }
    }
}