<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Faculty;
use App\Models\Scholar;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function all()
    {
        $faculty = Faculty::all();

        echo "#=== Fakulties ===#<br>";
        foreach ($faculty as $i => $row) {
            echo ++$i . ".) {$row->name} | {$row->dean} <br>";
        }

        $depart = Departement::all();

        echo "#=== Departements ===#<br>";
        foreach ($depart as $i => $row) {
            echo ++$i . ".) {$row->name} | {$row->departement_head} | {$row->capacity} <br>";
        }


        $scholar = Scholar::all();

        echo "#=== Scholars ===#<br>";
        foreach ($scholar as $i => $row) {
            echo ++$i . ".) {$row->sid} | {$row->name} | {$row->departement_id} <br>";
        }
    }

    public function relationship1()
    {
        // Fakultas Teknik Informatika
        $informatika = Faculty::where('name', 'Fakultas Teknik Informatika')->first();

        echo "#=== Jurusan Teknik Informatika ===#<br>";
        foreach ($informatika->departement as $i => $row) {
            echo ++$i . ".) {$row->name}<br>";
        }

        // Fakultas Sistem Informasi
        $informasi = Faculty::where('name', 'Fakultas Sistem Informasi')->first();

        echo "<br>#=== Jurusan Sistem Informasi ===#<br>";
        foreach ($informasi->departement as $i => $row) {
            echo ++$i . ".) {$row->name}<br>";
        }
    }

    public function relationship2()
    {
        $informasi = Faculty::where('name', "Fakultas Sistem Informasi")->first();

        echo "#=== Mahasiswa Sistem Informasi ===#<br>";
        foreach ($informasi->departement as $row) {
            // dump($row->scholar);
            foreach ($row->scholar as $cell) {
                echo "{$cell->name} <br>";
            }
        }
    }

    public function relationship3()
    {
        $informatika = Faculty::where('name', "Fakultas Teknik Informatika")->first();

        echo "#=== Mahasiswa Teknik Informatika ===# <br>";
        foreach ($informatika->scholar as $i => $row) {
            echo ++$i . ".) {$row->sid} | {$row->name} <br>";
        }
    }

    public function count()
    {
        $fac = Faculty::withCount('scholar')->get();
        // method withCount() akan menambahkan property scholar_count yang berisi jumlah mahasiswa dari setiap fakultas

        foreach ($fac as $row) {
            echo " Jurusan {$row->name} memiliki {$row->scholar_count} mahasiswa <br>";
        }
    }
}