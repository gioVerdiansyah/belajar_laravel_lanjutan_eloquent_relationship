<?php

namespace Database\Seeders;

use App\Models\Academic_Report;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = Student::with('grade')->has('grade')->get();
        $reports = [
            'A' => "Anda memiliki prestasi yang sangat baik. Pertahankan kerja keras Anda!",
            'B' => "Anda telah berhasil dengan baik. Tetap semangat untuk terus meningkatkan prestasi!",
            'C' => "Nilai Anda cukup memadai. Terus usahakan agar dapat mencapai prestasi yang lebih tinggi!",
            'D' => "Perlu perbaikan dalam prestasi akademik Anda. Coba untuk lebih fokus pada pembelajaran.",
            'E' => "Anda perlu melakukan upaya lebih besar dalam pembelajaran. Jangan menyerah!",
            'F' => "Tetap semangat dan coba untuk memperbaiki hasil belajar Anda.",
        ];

        foreach ($students as $student) {
            $grade = $student->grade->grade; // Nilai grade dari tabel Grades
            $report = $reports[$grade]; // Pesan berdasarkan nilai grade

            // Insert ke tabel Academic_Reports
            Academic_Report::create([
                'report' => $report,
                'grade_id' => $student->grade->student_id,
            ]);
        }

        // $reports = [
        //     "Anda memiliki prestasi yang sangat baik. Pertahankan kerja keras Anda!",
        //     "Anda telah berhasil dengan baik. Tetap semangat untuk terus meningkatkan prestasi!",
        //     "Nilai Anda cukup memadai. Terus usahakan agar dapat mencapai prestasi yang lebih tinggi!",
        //     "Perlu perbaikan dalam prestasi akademik Anda. Coba untuk lebih fokus pada pembelajaran.",
        //     "Anda perlu melakukan upaya lebih besar dalam pembelajaran. Jangan menyerah!",
        //     "Tetap semangat dan coba untuk memperbaiki hasil belajar Anda.",
        // ];
        // Academic_Report::create([
        //     'report' => $reports[0],
        //     'grade_id' => 1
        // ]);
        // Academic_Report::create([
        //     'report' => $reports[1],
        //     'grade_id' => 2
        // ]);
        // Academic_Report::create([
        //     'report' => $reports[2],
        //     'grade_id' => 3
        // ]);
        // Academic_Report::create([
        //     'report' => $reports[3],
        //     'grade_id' => 4
        // ]);
        // Academic_Report::create([
        //     'report' => $reports[4],
        //     'grade_id' => 5
        // ]);
        // Academic_Report::create([
        //     'report' => $reports[5],
        //     'grade_id' => 6
        // ]);
    }
}