<?php

namespace App\Http\Controllers;

use App\Models\Jurusans;
use App\Models\Siswas;
use Illuminate\Http\Request;

class SiswasController extends Controller
{
    protected $formatNIS = "35##/6##.0##";
    protected function singkatJurusan(string $namaJurusan)
    {
        return implode('', array_map(fn($nama) => strtoupper(substr($nama, 0, 1)), explode(" ", $namaJurusan)));
    }
    public function find()
    {
        $siswa = Siswas::find(5);

        echo "Siswa {$siswa->nama} dari Jurusan {$siswa->jurusans->nama}";
    }

    public function where()
    {
        $siswas = Siswas::where('nama', 'LIKE', 'C%')->orderBy('nama', 'DESC')->get();

        foreach ($siswas as $row) {
            echo "Siswa {$row->nama} dari jurusan {$row->jurusans->nama}<br>";
        }
    }

    public function whereChaining()
    {
        echo Siswas::where('nama', 'Cawuk Siregar')->firstOrFail()->jurusans->nama;
    }

    public function has()
    {
        $siswas = Siswas::has('jurusans')->orderBy('nama', 'DESC')->get();

        foreach ($siswas as $row) {
            echo $row->nama . "<br>";
        }
    }

    public function whereHas()
    {
        // ! Penemuan coyy
        $jurusan = fake()->randomElement(Jurusans::pluck('nama')->toArray());

        $siswas = Siswas::whereHas('jurusans', function ($query) use ($jurusan) {
            $query->where('nama', $jurusan);
        })->orderBy('nama', 'DESC')->get();

        echo "#=== List siswa dari jurusan {$this->singkatJurusan($jurusan)} ===#";
        foreach ($siswas as $i => $row) {
            echo "<br> " . $i + 1 . ".) {$row->nama}";
        }
    }

    public function doesntHave()
    {
        $siswas = Siswas::doesntHave('jurusans')->get();

        foreach ($siswas as $i => $siswa) {
            echo ($i + 1) . ".) {$siswa->nama}<br>";
        }
        dump($siswas); // tidak ada data didalam array
    }

    public function associate()
    {
        $jurusan = Jurusans::where('nama', "Teknik Sepeda Motor")->first();
        $siswa = new Siswas;
        $siswa->nis = fake()->unique()->numerify($this->formatNIS);
        $siswa->nama = fake('id_ID')->firstName() . " " . fake('id_ID')->lastName();

        $siswa->jurusans()->associate($jurusan);
        // untuk menghubungkan object $mahasiswa dengan $jurusan. Dengan perintah ini, property jurusan_id milik $mahasiswa akan langsung berisi id dari object $jurusan.
        $siswa->save();
        echo "Penambahan siswa {$siswa->nama} berhasil ditambahkan kedalam jurusan {$this->singkatJurusan($jurusan->nama)}";
    }

    public function associateUpdate()
    {
        $jurusan = Jurusans::where('nama', Jurusans::pluck('nama')->random())->first();
        $siswa = Siswas::where('nama', "LIKE", "C%")->first();

        $jurusanLama = $siswa->jurusans;

        $siswa->jurusans()->associate($jurusan);
        $siswa->save();

        echo "Siswa {$siswa->nama} dari Jurusan {$this->singkatJurusan($jurusanLama->nama)} ke Jurusan {$this->singkatJurusan($jurusan->nama)}";

        //! Penemuan lagi coyy
    }

    public function delete()
    {
        $siswa = Siswas::whereHas('jurusans', function ($query) {
            $query->where('nama', "Teknik Sepeda Motor");
        })->get();

        echo "#=== Menghapus semua siswa yang ada di jurusan TSM ===#<br>";

        foreach ($siswa as $i => $row) {
            echo ++$i . ".) Siswa {$row->nama} berhasil di hapus!<br>";
            $row->delete();
        }
    }

    public function dissociate()
    {
        $siswa = Siswas::whereHas('jurusans', function ($query) {
            $query->where('nama', "Teknik Kendaraan Ringan");
        })->get();

        echo "#=== Dissociate siswa dari jurusan TSM ==#<br>";

        foreach ($siswa as $i => $row) {
            $row->jurusans()->dissociate();
            $row->save();

            echo ++$i . ".) Siswa {$row->nama} berhasil di dissociate <br>";
        }
    }

    // Mencoba me associate lagi
    public function associateKembali()
    {
        $siswas = Siswas::whereNull('jurusans_id')->get();

        echo "#=== Meassociate kan kembali siswa yang di dissociate ===#<br>";

        foreach ($siswas as $i => $row) {
            $jurusan = Jurusans::where('nama', "Teknik Kendaraan Ringan")->first();

            $row->jurusans()->associate($jurusan);
            $row->save();

            echo ++$i . ".)" . $row->nama . " -> " . $this->singkatJurusan($jurusan->nama) . "<br>";
        }
        // Sebenarnya konsepnya mirip pada method associateUpdate() yang kita buat namun di kasih perulangan saja agar data yang diupdate bisa banyak, jangan lupa get() jika ingin mendapatkan banyak data
    }
}