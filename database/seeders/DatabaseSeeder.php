<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call(MahasiswaSeeder::class);
        // $this->call(NilaiSeeder::class);
        //di panggil terpisah agar tidak bentrok dengan id yang belum ada yang di hasilkan oleh fake()

        // $this->call(JurusanSeeder::class);
        // $this->call(SiswasSeeder::class);

        // $this->call(AuthorSeeder::class);
        // $this->call(BookSeeder::class);

        // $this->call(StudentSeeder::class);
        // $this->call(GradeSeeder::class);
        // $this->call(AcademicReportSeeder::class);

        $this->call(FacultySeeder::class);
        $this->call(DepartementSeeder::class);
        $this->call(ScholarSeeder::class);
    }
}