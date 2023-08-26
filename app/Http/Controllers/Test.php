<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Faker\Factory as Faker;

class Test extends Controller
{
    public function __invoke()
    {
        $faker = Faker::create();

        $jurusan = ["Sarjana Teknik Sipil", "Sarjana Teknik Elektro", "Sarjana Teknik Mesin", "Sarjana Teknik Kimia", "Sarjana Teknik Industri", "Sarjana Teknik Informatika", "Sarjana Sistem Informasi", "Sarjana Desain Grafis", "Sarjana Animasi", "Sarjana Multimedia", "Sarjana Teknologi Informasi", "Sarjana Ilmu Komputer", "Sarjana Teknik Telekomunikasi", "Sarjana Teknik Biomedis", "Sarjana Teknik Lingkungan", "Sarjana Teknik Pertambangan", "Sarjana Teknik Pangan", "Sarjana Teknik Pertanian", "Sarjana Teknik Logistik"];

        $title = [
            "S.T",
            "S.Ds",
            "S.A",
            "S.M",
            "S.T.I",
            "S.Kom",
        ];

        $siswa = [
            'nama' => $faker->firstName . " " . $faker->lastName,
            'jurusan' => $faker->randomElement($jurusan)
        ];

        $cariKata = function () use ($siswa) {
            return substr(explode(" ", $siswa['jurusan'])[1], 0, 1);
        };

        if (substr(explode(" ", $siswa['jurusan'])[2], 0, 1) == "I" && substr($siswa['jurusan'], 8, 1) == "T") {
            $siswa['nama'] = $siswa['nama'] . " " . $title[4];
        } else {
            switch ($cariKata()) {
                case 'T':
                    $siswa['nama'] = $siswa['nama'] . " " . $title[0];
                    break;
                case 'D':
                    $siswa['nama'] = $siswa['nama'] . " " . $title[1];
                    break;
                case 'A':
                    $siswa['nama'] = $siswa['nama'] . " " . $title[2];
                    break;
                case 'M':
                    $siswa['nama'] = $siswa['nama'] . " " . $title[3];
                    break;
                default:
                    $siswa['nama'] = $siswa['nama'] . " " . end($title);
                    break;
            }
        }

        echo "Nama: " . $siswa['nama'] . "<br>";
        echo "Jurusan: " . $siswa['jurusan'] . "<br>";
    }
}