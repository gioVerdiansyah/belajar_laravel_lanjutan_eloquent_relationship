<?php

namespace App\Http\Controllers;

use App\Models\Academic_Report;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
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

    public function relationship1()
    {
        echo "#=== Student ===# <br>";
        $students = Student::with('grade')->has('grade')->get();
        foreach ($students as $i => $row) {
            echo ++$i . ".) {$row->nama} | {$row->grade->sem_1} | {$row->grade->sem_2} | {$row->grade->sem_3} | {$row->grade->grade}<br>";
        }

        echo "<hr>";

        echo "#=== Grade ===# <br>";
        $grade = Grade::with('academicReport')->has('academicReport')->get();
        foreach ($grade as $i => $row) {
            echo ++$i . ".) {$row->sem_1} | {$row->sem_2} | {$row->sem_3} | {$row->grade} | {$row->academicReport->report}<br>";
        }
    }

    public function relationship2()
    {
        $student = Student::with('grade')->has('grade')->get();

        foreach ($student as $i => $row) {
            // if ($row->grade->academicReport && $row->grade->academicReport->report !== null) {
            echo ++$i . ".) {$row->nama} | {$row->grade->grade} | {$row->grade->academicReport->report} <br>";
            // }
            // saya menggunakan if agar menyaring user yang tidak memiliki hubungan dengan tabel report
        }
    }

    public function relationship3()
    {
        $students = Student::with('academicReport')->has('academicReport')->get();

        echo "#=== Student - Academic Report ===# <br>";
        foreach ($students as $i => $row) {
            echo ++$i . ".) {$row->nama} | {$row->grade->grade} | {$row->grade->academicReport->report} <br>";
        }
    }

    protected function studentGrade()
    {
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
    public function input1()
    {
        $student = Student::where('nama', "Aurora Wijayanti")->first();

        $grade = new Grade;
        $studentGrade = $this->studentGrade();
        // jangan lupa data di simpan dahulu agar saat pencocokan grade data tidak menjadi random lagi
        $grade->sem_1 = $studentGrade['sem_1'];
        $grade->sem_2 = $studentGrade['sem_2'];
        $grade->sem_3 = $studentGrade['sem_3'];
        $grade->grade = $studentGrade['grade'];

        $student->grade()->save($grade);

        $report = new Academic_Report;
        $report->report = $this->studentReport($studentGrade['grade']);

        $student->academicReport()->save($report);

        echo "Penambahan data {$student->nama} berhasil!";
    }
    public function input2()
    {
        $student = Student::where('nama', "Hasim Habibi")->first();

        $grade = new Grade;
        $studentGrade = $this->studentGrade();
        $grade->sem_1 = $studentGrade['sem_1'];
        $grade->sem_2 = $studentGrade['sem_2'];
        $grade->sem_3 = $studentGrade['sem_3'];
        $grade->grade = $studentGrade['grade'];

        $student->grade()->save($grade);

        $report = new Academic_Report;
        $report->report = $this->studentReport($studentGrade['grade']);

        $grade->academicReport()->save($report);

        // menggunakan grade karena ingat urutan ke3 tabel ini adalah students->grades->academic__reports

        echo "Penambahan data {$student->nama} berhasil!";
    }

    public function update()
    {
        $student = Student::where('nama', "Hasim Habibi")->first();
        $grade = $student->grade->grade; // mendapatkan nilai grade dari siswa tersebut

        $report = $student->academicReport; //select model academicReport dari Has One Through
        $report->report = $this->studentReport($grade);
        //diisi dengan fungsi yang otomatis memiliah dari grade yang di berikan dan memberi report sesuai grade tersebut

        $report->save();

        echo "Update data nama {$student->nama} berhasil!";
    }

    public function delete()
    {
        $student = Student::where('nama', "Elvina Kuswandari")->first();
        $student->delete();
        // efek dari hapus ini akan menghapus data dari tabel yang berhubungan dengannya yaitu tabel grades dan academic__reports, efek ini berjalan karen saat pendefinisan migrations

        echo "Data {$student->nama} berhsail dihapus!";
    }

    //  saat ini Laravel tidak menyediakan relationship belongs to through, yakni hubungan timbal balik dari tabel rapors ke tabel mahasiswas. Jika ingin membuatnya, bisa memakai library pihak ketiga seperti staudenmeir/belongs-tothrough ( https://github.com/staudenmeir/belongs-to-through ).
}