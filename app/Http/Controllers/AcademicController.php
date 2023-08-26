<?php

namespace App\Http\Controllers;

use App\Models\Academic_Report;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;

class AcademicController extends Controller
{
    protected $reports = [
        'A' => "Anda memiliki prestasi yang sangat baik. Pertahankan kerja keras Anda!",
        'B' => "Anda telah berhasil dengan baik. Tetap semangat untuk terus meningkatkan prestasi!",
        'C' => "Nilai Anda cukup memadai. Terus usahakan agar dapat mencapai prestasi yang lebih tinggi!",
        'D' => "Perlu perbaikan dalam prestasi akademik Anda. Coba untuk lebih fokus pada pembelajaran.",
        'E' => "Anda perlu melakukan upaya lebih besar dalam pembelajaran. Jangan menyerah!",
        'F' => "Tetap semangat dan coba untuk memperbaiki hasil belajar Anda.",
    ];
    public function all()
    {
        echo "#=== Student ===# <br>";
        $students = Student::all();
        foreach ($students as $i => $row) {
            echo ++$i . ".) {$row->nis} | {$row->nama} |  {$row->jurusan} <br>";
        }

        echo "<hr>";

        echo "#=== Grade ===# <br>";
        $grade = Grade::all();
        foreach ($grade as $i => $row) {
            echo ++$i . ".) {$row->sem_1} | {$row->sem_2} | {$row->sem_3} | {$row->student_id} <br>";
        }

        echo "<hr>";

        echo "#=== Academic Report ===# <br>";
        $report = Academic_Report::all();
        foreach ($report as $i => $row) {
            echo ++$i . ".) {$row->report} ({$row->grade_id}) <br>";
        }
    }

    public function belongsToThrough()
    {
        $report = Academic_Report::find(1);
        echo "Nama: {$report->student->nama}";
    }

    public function relationship1()
    {
        $report = Academic_Report::with('student')->has('student')->get();

        echo "#=== Students ===#<br>";
        foreach ($report as $i => $row) {
            echo ++$i . ".) {$row->student->nama} | {$row->grade->sem_1} | {$row->grade->sem_2} | {$row->grade->sem_3} | {$row->grade->grade} | {$row->student->academicReport->report} <br>";
        }
    }

    public function relationship2()
    {
        $report = Academic_Report::with('grade')->has('grade')->get();

        echo "#=== Students ===#<br>";
        foreach ($report as $i => $row) {
            echo ++$i . ".) {$row->report} | {$row->grade->grade} | {$row->grade->student->nama}<br>";
        }

        // Ternyata sama-sama masih bisa mengakses baik dari grade maupun dari student langsung, karena saya sudah mendefinisikannya di dalam model Academic ini
    }

    protected function studentGrade()
    {
        $sem_1 = fake()->randomFloat(2, 55, 90);
        $sem_2 = fake()->randomFloat(2, 55, 90);
        $sem_3 = fake()->randomFloat(2, 55, 90);
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
        return [
            'sem_1' => $sem_1,
            'sem_2' => $sem_2,
            'sem_3' => $sem_3,
            'grade' => $grade
        ];
    }

    protected function studentReport($grade)
    {
        $reports = [
            'A' => "Anda memiliki prestasi yang sangat baik. Pertahankan kerja keras Anda!",
            'B' => "Anda telah berhasil dengan baik. Tetap semangat untuk terus meningkatkan prestasi!",
            'C' => "Nilai Anda cukup memadai. Terus usahakan agar dapat mencapai prestasi yang lebih tinggi!",
            'D' => "Perlu perbaikan dalam prestasi akademik Anda. Coba untuk lebih fokus pada pembelajaran.",
            'E' => "Anda perlu melakukan upaya lebih besar dalam pembelajaran. Jangan menyerah!",
            'F' => "Tetap semangat dan coba untuk memperbaiki hasil belajar Anda.",
        ];

        $report = $reports[$grade];
        return $report;
    }

    public function create()
    {
        // Karena tabel academic sudah berrelasi semua dengan student maka kita purlu data kosing dulu untuk di hubungkan
        // Karena kita masih memiliki sisa siswa yang belum berrelasi dengan academic maka kita bisa hubungkan tanpa menambah data di student

        $student = Student::whereDoesntHave('grade')->first();

        // ? karena tabel academic harus memiliki hubungan dengan grade maka kita harus menambah isi tabel baru ke dalam grades dahulu

        $grade = new Grade;
        $studentGrade = $this->studentGrade();
        $grade->sem_1 = $studentGrade['sem_1'];
        $grade->sem_2 = $studentGrade['sem_2'];
        $grade->sem_3 = $studentGrade['sem_3'];
        $grade->grade = $studentGrade['grade'];

        $student->grade()->save($grade);

        $report = new Academic_Report;
        $report->report = $this->studentReport($studentGrade['grade']);
        $report->grade_id = $student->id;

        $report->save();

        echo "Data grade dan raport berhasil dibuat untuk siswa yang berlum memiliki relasi <br> {$student->nama} | {$grade->grade} | {$report->report}";

        // APA BEDANYA BANGKE SAMA HAS ONE THROUGH???
    }
    public function create2()
    {
        $student = Grade::whereDoesntHave('academicReport')->first();
        // siswa yang belum memiliki relasi dengan academic

        $report = new Academic_Report;
        $report->report = $this->studentReport($student->grade);

        $student->academicReport()->save($report);

        echo "Penambahan data berhasil!";
    }

    public function update()
    {
        $report = Academic_Report::with('grade')->whereHas('grade', function ($query) {
            $query->where('grades.sem_3', 55.17);
        })->first();

        if ($report) {
            $report->grade->sem_3 = 55.20;
            $report->grade->save();

            echo "Update data berhsail!";
        } else {
            echo "Tidak ada data yang terkait";
        }
    }

    public function delete()
    {
        $report = Academic_Report::where('grade_id', 8)->first();
        $report->delete();
        echo "laporan berhasil di hapus!";
    }
}