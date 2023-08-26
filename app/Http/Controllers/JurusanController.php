<?php

namespace App\Http\Controllers;

use App\Models\Jurusans;
use App\Models\Siswas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JurusanController extends Controller
{
    protected $formatNIS = "35##/6##.0##";
    public function all()
    {
        $jurusans = DB::select("SELECT * FROM jurusans");
        foreach ($jurusans as $jurusan) {
            echo "{$jurusan->nama} | {$jurusan->kepala_jurusan} | {$jurusan->daya_tampung} <br>";
        }
    }
    public function gabung()
    {
        $jurusans = DB::select("SELECT jurusans.nama AS nama_jurusan , siswas.id AS id_siswa , siswas.nama AS nama_siswa FROM jurusans, siswas WHERE jurusans.id = siswas.jurusan_id");

        foreach ($jurusans as $row) {
            echo "{$row->nama_jurusan} | {$row->nama_siswa} | ({$row->id_siswa}) <br>";
        }
    }
    public function gabungJoin()
    {
        // Alternatif lain bisa menggunakan JOIN
        $jurusans = DB::select('SELECT jurusans.nama AS nama_jurusan, siswas.id AS id_siswa, siswas.nama AS nama_siswa FROM jurusans JOIN siswas ON jurusans.id = siswas.jurusan_id WHERE jurusans.nama = "Rekayasa Perangkat Lunak"');

        foreach ($jurusans as $row) {
            echo "{$row->nama_jurusan} | {$row->nama_siswa} ({$row->id_siswa}) <br>";
        }
    }


    // ! has many
    public function find()
    {
        $jurusan = Jurusans::find(1);
        // dump($jurusan->siswas);

        echo "
        Nama Jurusan: {$jurusan->nama}              <br>
        Kepala Jurusan: {$jurusan->kepala_jurusan}  <br>
        Data Tampung: {$jurusan->daya_tampung}      <br>
        <br>
        #=== Daftar Siswa SMKN 1 Mejayan ===#
        <br>";

        $i = 0;
        foreach ($jurusan->siswas as $row) {
            echo ++$i . ".) {$row->nis} | {$row->nama} <br>";
        }
    }

    public function where()
    {
        $jurusans = Jurusans::where("kepala_jurusan", "Vera Yuniar")->first();

        echo "
        Nama Jurusan: {$jurusans->nama}              <br>
        Kepala Jurusan: {$jurusans->kepala_jurusan}  <br>
        Data Tampung: {$jurusans->daya_tampung}      <br>
        <br>
        #=== Daftar Siswa SMKN 1 Mejayan ===#
        <br>";

        $i = 0;
        foreach ($jurusans->siswas as $row) {
            echo ++$i . ".) {$row->nis} | {$row->nama} <br>";
        }
    }

    public function joinAll()
    {
        $jurusans = Jurusans::all();

        foreach ($jurusans as $row) {
            echo "
            Jurusan : {$row->nama} ({$row->daya_tampung} orang) <br>
            Kepala Jurusan : {$row->kepala_jurusan} <br>
            Mahasiswa :
            <ul style='margin:0'>";
            foreach ($row->siswas as $cell) {
                echo "<li>{$cell->nama}({$cell->nis})</li>";
            }
            echo "</ul><hr>";
        }
    }

    public function has()
    {
        $jurusans = Jurusans::has('siswas')->get();

        foreach ($jurusans as $row) {
            echo "{$row->nama} | ";
        }
    }

    public function whereHas()
    {
        $jurusans = Jurusans::whereHas('siswas', function ($query) {
            $query->where("jurusans.nama", "LIKE", "%Tek%");
            // saya beri tambahan jurusans karen biar spesifik, karena ada tabel memiliki column bernama "nama" 2
        })->get();

        foreach ($jurusans as $row) {
            echo "{$row->nama} | ";
        }
    }

    public function doesntHave()
    {
        $jurusans = Jurusans::doesntHave('siswas')->get();

        foreach ($jurusans as $row) {
            echo "{$row->nama} | ";
        }
    }

    public function withCount()
    {
        $jurusans = Jurusans::withCount('siswas')->get();
        dump($jurusans);

        foreach ($jurusans as $row) {
            echo "{$row->nama} ({$row->siswas_count} siswa) <br>";
        }
    }

    public function loadCount()
    {
        $jurusans = Jurusans::where("nama", 'LIKE', "Tek%")->get()->loadCount('siswas');

        foreach ($jurusans as $row) {
            echo "{$row->nama} ({$row->siswas_count} siswa) <br>";
        }
    }

    // ! Atur Nilai
    protected function addSiswa()
    {
        return [
            'nis' => fake()->unique()->numerify($this->formatNIS),
            'nama' => fake('id_ID')->firstName() . " " . fake('id_ID')->lastName()
        ];
    }
    protected function addBanyakSiswa(int $n = 5)
    {
        $data = [];
        for ($i = 1; $i <= $n; $i++) {
            $data[] = [
                'nis' => fake()->unique()->numerify($this->formatNIS),
                'nama' => fake('id_ID')->firstName() . " " . fake('id_ID')->lastName()
            ];
        }
        return $data;
    }
    protected function singkat(string $string)
    {
        return implode('', array_map(fn($word) => strtoupper(substr($word, 0, 1)), explode(" ", $string)));
    }

    // ! Atur Data
    public function insertSave()
    {
        $jurusan = new Jurusans;
        $jurusan->nama = "Teknik Komputer Jaringan";
        $jurusan->kepala_jurusan = fake('id_ID')->name();
        $jurusan->daya_tampung = fake()->randomElement([70, 90]);
        $jurusan->save();

        $siswa = new Siswas;
        $siswa->nis = fake()->unique()->numerify($this->formatNIS);
        $siswa->nama = fake('id_ID')->firstName() . " " . fake('id_ID')->lastName();

        $jurusan->siswas()->save($siswa);
        echo "Penambahan Jurusan \"{$jurusan->nama}\" berhasil ditambahkan dengan mahasiswa baru \"{$siswa->nama}\"";
    }
    public function insertCreate()
    {
        $jurusan = Jurusans::where('nama', "Agribisnis Pengolahan Hasil Pertanian")->first();

        $siswa = new Siswas;
        $jurusan->siswas()->create($this->addSiswa());

        echo "Penambahan siswa baru berhasil ditambahkan!";
    }

    public function insertCreateMany()
    {
        $jurusan = Jurusans::where('nama', "Teknik Komputer Jaringan")->first();

        $jurusan->siswas()->createMany($this->addBanyakSiswa());
        echo "Penambahan siswa baru berhasil ditambahkan kedalam Database!";
    }

    // update
    public function update()
    {
        $jurusan_aphp = Jurusans::where('nama', "Agribisnis Pengolahan Hasil Pertanian")->first();
        $jurusan_tkj = Jurusans::where('nama', "Teknik Komputer Jaringan")->first();

        $jurusan_tkj->siswas()->update([
            'jurusans_id' => $jurusan_aphp->id
        ]);

        echo "Semua siswa jurusan " . $this->singkat($jurusan_tkj->nama) . " telah dipindah ke jurusan " . $this->singkat($jurusan_aphp->nama);
    }

    public function updatePush()
    {
        $jurusan = Jurusans::where('nama', "Rekayasa Perangkat Lunak")->first();

        echo "#=== Penambahan Title S.Kom pada Jurusan {$this->singkat($jurusan->nama)} berhasil ditambah ===# <br> ";
        foreach ($jurusan->siswas as $siswa) {
            $siswa->nama = $siswa->nama . " S.Kom";
            $siswa->push();

            echo $siswa->nama . "<br>";
        }
    }

    public function delete()
    {
        $jurusan = Jurusans::where('nama', "Teknik Komputer Jaringan")->firstOrFail();
        $jurusan->delete();

        echo "Jurusan {$this->singkat($jurusan->nama)} berhasil di hapus!";
    }
}