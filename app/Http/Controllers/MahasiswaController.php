<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    protected $tabel1 = 'mahasiswas', $tabel2 = 'nilais', $jurusan = ["Ilmu Komputer", "Teknik Informatika", "Sistem Informasi"];
    public function all()
    {
        $mahasiswas = DB::select("SELECT * FROM {$this->tabel1}");
        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan <br>";
        }
    }
    public function gabung1()
    {
        $mahasiswas = DB::select(
            "SELECT * FROM {$this->tabel1}, {$this->tabel2} WHERE {$this->tabel1}.id = {$this->tabel2}.mahasiswa_id"
        );
        //  "ambil semua kolom yang ada di tabel mahasiswas dan tabel nilais, dengan syarat data kolom id di tabel mahasiswas harus sama dengan kolom mahasiswa_id di tabel nilais"
        dump($mahasiswas);
    }
    public function gabung2()
    {
        $mahasiswas = DB::select(
            "SELECT * FROM {$this->tabel1}, {$this->tabel2} WHERE {$this->tabel1}.id = {$this->tabel2}.mahasiswa_id"
        );

        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan ";
            echo " |$mahasiswa->sem_1 | $mahasiswa->sem_2 | $mahasiswa->sem_3 <br> ";
        }
    }
    public function gabungJoin1()
    {
        $mahasiswas = DB::select(
            "SELECT * FROM {$this->tabel1} JOIN {$this->tabel2} ON {$this->tabel1}.id = {$this->tabel2}.mahasiswa_id"
        );
        // "ambil semua kolom di tabel mahasiswas yang di-join dengan tabel nilais, dengan syarat data kolom id di tabel mahasiswas harus sama dengan kolom mahasiswa_id di tabel nilais"

        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan ";
            echo " |$mahasiswa->sem_1 | $mahasiswa->sem_2 | $mahasiswa->sem_3 <br> ";
        }
    }
    public function gabungJoin2()
    {
        // Bisa juga di kasih kondisi
        $mahasiswas = DB::select(
            "SELECT * FROM {$this->tabel1} JOIN {$this->tabel2} ON {$this->tabel1}.id = {$this->tabel2}.mahasiswa_id WHERE jurusan = 'Teknik Informatika'"
        );

        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan ";
            echo " |$mahasiswa->sem_1 | $mahasiswa->sem_2 | $mahasiswa->sem_3 <br> ";
        }
    }
    public function gabungJoin3()
    {
        // Bisa juga di kasih kondisi pada bagian tabel nilai
        $mahasiswas = DB::select(
            "SELECT * FROM {$this->tabel1} JOIN {$this->tabel2} ON {$this->tabel1}.id = {$this->tabel2}.mahasiswa_id WHERE {$this->tabel2}.sem_3 > 3"
        );

        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan ";
            echo " |$mahasiswa->sem_1 | $mahasiswa->sem_2 | $mahasiswa->sem_3 <br> ";
        }
    }

    public function find()
    {
        $mahasiswa = Mahasiswa::find(2);
        // dump($mahasiswa);
        // Karena kita sudah mendefinisikan relationship antara model Mahasiswa dengan model Nilai menggunakan method nilai()
        // dump($mahasiswa->nilai);
        // carilah id yang memiliki hubungan dengan nilai

        dump($mahasiswa->toArray());
        dump($mahasiswa->nilai->toArray());

        echo "{$mahasiswa->nim} | {$mahasiswa->nama} | {$mahasiswa->jurusan} | {$mahasiswa->nilai->sem_1} | {$mahasiswa->nilai->sem_2} | {$mahasiswa->nilai->sem_3}";
    }

    public function where()
    {
        $mahasiswa = Mahasiswa::where('nama', 'Kawaya Yuniar')->first();

        echo "{$mahasiswa->nim} | {$mahasiswa->nama} | {$mahasiswa->jurusan} | {$mahasiswa->nilai->sem_1} | {$mahasiswa->nilai->sem_2} | {$mahasiswa->nilai->sem_3}";
    }
    public function whereChaining()
    {
        $mahasiswa = Mahasiswa::where('nama', 'Kawaya Yuniar')->first()->nilai->sem_1;

        echo $mahasiswa;
    }
    public function allJoin()
    {
        // $mahasiswas = Mahasiswa::all();
        // Jika langsung all maka akan mengambil data satu persatu, ini di namakan Lazy Loading, jika data masih sedikit ini lebih efesien, namun jika data banyak maka tidak lagi efesien

        $mahasiswas = Mahasiswa::with('nilai')->get();
        // Method with() butuh 1 argument berupa nama method yang dipakai untuk membuat relasi.
        //Solusi ini desebut dengan Eager Loading
        // Sepintas eager loading terlihat lebih efisien, namun jika kita hanya perlu mengakses 1 atau 2 data di tabel nilais, malah jadi boros resources. Jika terdapat 1000 data nilai, maka di memory server butuh ruang untuk menampung seluruh nilai-nilai ini

        foreach ($mahasiswas as $mahasiswa) {
            echo "{$mahasiswa->nim} | {$mahasiswa->nama} | {$mahasiswa->jurusan} | ";
            echo $mahasiswa->nilai->sem_1 ?? "N/A";
            echo " | ";
            echo $mahasiswa->nilai->sem_2 ?? "N/A";
            echo " | ";
            echo $mahasiswa->nilai->sem_3 ?? "N/A";
            echo " | ";
            echo "<br>";
        }
    }

    public function has()
    {
        // $mahasiswas = Mahasiswa::has('nilai')->get();
        // has() digunakan untuk mengambil data yang hanya memiliki relasi di tabel nilai saja

        // versi eager loading
        $mahasiswas = Mahasiswa::with('nilai')->has('nilai')->get();

        foreach ($mahasiswas as $mahasiswa) {
            echo "{$mahasiswa->nim} | {$mahasiswa->nama} | {$mahasiswa->jurusan} | {$mahasiswa->nilai->sem_1} | {$mahasiswa->nilai->sem_2} | {$mahasiswa->nilai->sem_3} <br>";
        }
    }
    public function whereHas()
    {
        $mahasiswas = Mahasiswa::whereHas('nilai', function ($query) {
            $query->where('sem_1', '>', 3);
        })->get();

        // Jika ingin membuat versi Eager Loading bisa tambahkan with('nilai') sebelum method whereHas()

        foreach ($mahasiswas as $mahasiswa) {
            echo "{$mahasiswa->nim} | {$mahasiswa->nama} | {$mahasiswa->jurusan} | {$mahasiswa->nilai->sem_1} | {$mahasiswa->nilai->sem_2} | {$mahasiswa->nilai->sem_3} <br>";
        }
    }
    public function doesntHave()
    {
        $mahasiswas = Mahasiswa::doesnthave('nilai')->get();

        foreach ($mahasiswas as $mahasiswa) {
            echo "{$mahasiswa->nim} | {$mahasiswa->nama} | {$mahasiswa->jurusan}<br>";
        }
    }
    public function whereDoesntHave()
    {
        $mahasiswas = Mahasiswa::whereDoesnthave('nilai', function ($query) {
            $query->where('sem_1', '>', 3);
        })->get();

        // Jika ingin membuat gabungan logika or ada juga method orWhereDoesntHave()

        foreach ($mahasiswas as $mahasiswa) {
            echo "{$mahasiswa->nim} | {$mahasiswa->nama} | {$mahasiswa->jurusan}<br>";
        }
    }

    public function insertSave()
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

        $mahasiswa->nilai()->save($nilai);
        // peran diatas ini lah yang bertugas mengisi column mahasiswa_id milik tabel nilai, nilai ini akan berisi id terbaru dari tabel mahasiswas
        echo "Data $mahasiswa->nama berhasil ditambahkan!";
    }

    public function insertCreate()
    {
        $mahasiswa = Mahasiswa::create([
            'nim' => fake()->numerify('19######'),
            'nama' => fake('id_ID')->firstName() . " " . fake('id_ID')->lastName(),
            'jurusan' => fake()->randomElement($this->jurusan)
        ]);

        $mahasiswa->nilai()->create([
            'sem_1' => fake()->randomFloat(2, 2, 4),
            'sem_2' => fake()->randomFloat(2, 2, 4),
            'sem_3' => fake()->randomFloat(2, 2, 4)
        ]);

        echo "Data $mahasiswa->nama berhasil dibuat!";
    }

    public function update()
    {
        $mahasiswa = Mahasiswa::find(2);

        $mahasiswa->nilai()->update([
            'sem_1' => fake()->randomFloat(2, 1, 2),
            'sem_2' => fake()->randomFloat(2, 1, 2),
            'sem_3' => fake()->randomFloat(2, 1, 2),
        ]);

        echo "Data $mahasiswa->nama Berhasil di ubah!";
    }
    public function updatePush()
    {
        $mahasiswa = Mahasiswa::find(9);

        $mahasiswa->nilai->sem_1 = fake()->randomFloat(2, 1, 3);
        $mahasiswa->nilai->sem_2 = fake()->randomFloat(2, 1, 3);
        $mahasiswa->nilai->sem_3 = fake()->randomFloat(2, 1, 3);

        $mahasiswa->push();

        echo "Data $mahasiswa->nama Berhasil di ubah!";
    }
    public function updatePushWhere()
    {
        $mahasiswa = Mahasiswa::where('nama', 'Fathonah Hutasoit')->first();

        $mahasiswa->nilai->sem_1 = fake()->randomFloat(2, 1, 3);
        $mahasiswa->nilai->sem_2 = fake()->randomFloat(2, 1, 3);
        $mahasiswa->nilai->sem_3 = fake()->randomFloat(2, 1, 3);

        $mahasiswa->push();

        echo "Data $mahasiswa->nama Berhasil di ubah!";
    }

    // Referential integrity adalah sekumpulan aturan untuk menjaga konsistensi data yang saling berelasi. yakni:
    // 1. Satu mahasiswa hanya bisa memiliki satu nilai, dan satu nilai hanya bisa dimiliki oleh satu mahasiswa (aturan one to one relationship).
    // 2. Satu data nilai tidak bisa dibuat tanpa mengisi kolom id_mahasiswa. Dengan kata lain, setiap nilai harus 'melekat' ke satu mahasiswa.
    // Ketika akan menghapus data, maka terdapat aturan lain:
    // 1. Data mahasiswa hanya bisa dihapus jika tidak ada nilai yang 'melekat' ke mahasiswa tersebut. Jika ingin menghapus satu data mahasiswa, nilainya harus dihapus terlebih dahulu. Namun tidak masalah jika ingin menghapus data nilai tanpa harus menghapus pasangan mahasiswanya.

    public function deleteFind()
    {
        $mahasiswa = Mahasiswa::find(2);
        // $mahasiswa->delete(); //tidak bisa jika langsung seperti ini
        $mahasiswa->nilai->delete();
        $mahasiswa->delete();
        // Harus nilai terlebih dahulu baru mahasiswanya

        echo "Data $mahasiswa->nama berhasil di hapus";
    }

    public function deleteWhere()
    {
        $mahasiswa = Mahasiswa::where('nama', 'Kawaya Yuniar')->firstOrFail();
        $mahasiswa->nilai->delete();
        $mahasiswa->delete();

        echo "Data $mahasiswa->nama berhasil di hapus!";
    }

    public function deleteIf()
    {
        $mahasiswa = Mahasiswa::where('nama', 'Ira Yolanda')->firstOrFail();
        // Karena nama Ira Yolanda tidak terhubung dengan nilai maka kita tidak bisa mengapus nilainya sekaligus, untuk itu kita perlu untuk memfilternya terlebih dahulu
        if (!empty($mahasiswa->nilai)) {
            $mahasiswa->nilai->delete();
        }

        $mahasiswa->delete();

        echo "Data $mahasiswa->nama Berhasil di hapus!";
    }

    public function deleteCascade()
    {
        $mahasiswa = Mahasiswa::where('nama', 'Vera Kuswandari')->firstOrFail();
        $mahasiswa->delete();
        echo "Data $mahasiswa->nama Berhasil di hapus!";
    }

    public function updateCascade()
    {
        $mahasiswa = Mahasiswa::where('nama', 'Fathonah Hutasoit')->firstOrFail();
        $mahasiswa->id = 100;
        $mahasiswa->push();

        echo "Data $mahasiswa->nama Berhasil di update!";
    }
}