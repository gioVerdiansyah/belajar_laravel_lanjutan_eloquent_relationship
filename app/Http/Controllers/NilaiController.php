<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\Nilai;

class NilaiController extends Controller
{
    protected $jurusan = ["Ilmu Komputer", "Teknik Informatika", "Sistem Informasi"];
    public function find()
    {
        $nilai = Nilai::find(2);
        echo "{$nilai->mahasiswa->nim} | {$nilai->mahasiswa->nama} | {$nilai->mahasiswa->jurusan} | {$nilai->sem_1} | {$nilai->sem_2} | {$nilai->sem_3}";
    }
    public function where()
    {
        $nilai = Nilai::where("sem_1", ">=", 3.6)->first();
        echo "{$nilai->mahasiswa->nim} | {$nilai->mahasiswa->nama} | {$nilai->mahasiswa->jurusan} | {$nilai->sem_1} | {$nilai->sem_2} | {$nilai->sem_3}";
    }

    public function whereChaining()
    {
        echo Nilai::where('sem_3', '>', 3)->first()->mahasiswa->nama;
    }

    public function has()
    {
        $nilais = Nilai::has('mahasiswa')->get();

        foreach ($nilais as $nilai) {
            echo "{$nilai->mahasiswa->nama} | ";
        }
    }

    public function hasEager()
    {
        $nilais = Nilai::with('mahasiswa')->has('mahasiswa')->get();

        foreach ($nilais as $nilai) {
            echo "{$nilai->mahasiswa->nama} | ";
        }
    }

    public function testInput1()
    {
        // tes input 1 tanpa mengisi column mahasiswa_id
        $nilai = new Nilai;
        $nilai->sem_1 = 3.14;
        $nilai->sem_2 = 2.22;
        $nilai->sem_3 = 3.38;
        $nilai->save();

        echo "Penambahan data berhasil!";
        // SQLSTATE[HY000]: General error: 1364 Field 'mahasiswa_id' doesn't have a default value
    }
    public function testInput2()
    {
        // tes input 2 dengan mengisi column mahasiswa_id
        $nilai = new Nilai;
        $nilai->sem_1 = 3.14;
        $nilai->sem_2 = 2.22;
        $nilai->sem_3 = 3.38;
        $nilai->mahasiswa_id = 15;
        $nilai->save();

        echo "Penambahan data berhasil!";
        // SQLSTATE[23000]: Integrity constraint violation: 1452 Cannot add or update a child row: a foreign key constraint fails (`belajar_laravel_lanjutan_eloquent_relationship`.`nilais`, CONSTRAINT `nilais_mahasiswa_id_foreign` FOREIGN KEY...
    }
    public function testInput3()
    {
        // tes input 3 dengan mengisi column mahasiswa_id yang sudah ada
        $nilai = new Nilai;
        $nilai->sem_1 = 3.14;
        $nilai->sem_2 = 2.22;
        $nilai->sem_3 = 3.38;
        $nilai->mahasiswa_id = 2;
        $nilai->save();

        echo "Penambahan data berhasil!";
        // SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry '2' for key 'nilais_mahasiswa_id_unique'
    }
    public function testInput4()
    {
        // tes input 4 dengan mahasiswa yang belum memiliki nilai (bisa)
        $nilai = new Nilai;
        $nilai->sem_1 = 3.14;
        $nilai->sem_2 = 2.22;
        $nilai->sem_3 = 3.38;
        $nilai->mahasiswa_id = 5;
        $nilai->save();

        echo "Penambahan data berhasil!";
    }
    public function associateNew()
    {
        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = fake()->numerify('19######');
        $mahasiswa->nama = fake('id_ID')->firstName() . " " . fake('id_ID')->lastName();
        $mahasiswa->jurusan = fake()->randomElement($this->jurusan);
        $mahasiswa->save();

        $nilai = new Nilai;
        $nilai->sem_1 = fake()->randomFloat(2, 2, 4);
        $nilai->sem_2 = fake()->randomFloat(2, 2, 4);
        $nilai->sem_3 = fake()->randomFloat(2, 2, 4);

        $nilai->mahasiswa()->associate($mahasiswa);
        $nilai->save();

        echo "Penambahan data {$mahasiswa->nama} dan nilainya berhasil ditambahkan";
    }

    public function associateFind()
    {
        $mahasiswa = Mahasiswa::find(10);

        $nilai = new Nilai;
        $nilai->sem_1 = fake()->randomFloat(2, 2, 4);
        $nilai->sem_2 = fake()->randomFloat(2, 2, 4);
        $nilai->sem_3 = fake()->randomFloat(2, 2, 4);

        $nilai->mahasiswa()->associate($mahasiswa);
        $nilai->save();

        echo "Penghubungan data {$mahasiswa->nama} dengan nilainya berhasil di hubungkan!";
    }

    // Sebenarnya Laravel juga menyediakan method dissociate() untuk 'memutus' hubungan nilai dengan mahasiswa. Tapi ini tidak bisa kita pakai karena kolom mahasiswa_id di tabel nilais tidak boleh kosong (tidak di set sebagai nullable)

    public function delete()
    {
        $nilai = Nilai::find(5);
        $nilai->delete();

        echo "1 data nilai berhasil dihapus!";
    }
    public function deleteMahasiswa()
    {
        $nilai = Nilai::find(4);
        $nilai->delete();

        $nama_mahasiswa = $nilai->mahasiswa->nama;
        $nilai->mahasiswa()->delete();

        echo "Data {$nama_mahasiswa} beserta nilainya berhasil dihapus!";
    }
}