<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function all()
    {
        $authors = Author::all();

        foreach ($authors as $row) {
            echo "{$row->id}.) {$row->name} | {$row->created_at}<br>";
        }
    }

    public function attach()
    {
        $author = Author::find(3);
        $book = Book::find(2);

        // lakukan proses attach yakni proses menghubungkan anatara tabel author dan book
        $author->books()->attach($book);

        echo "Proses attach berhasil!";
    }

    public function attachArray()
    {
        $author = Author::where('name', "Kani Waskita")->first();
        $book = Book::find([1, 2, 3]);

        $author->books()->attach($book);

        echo "Proses attach banyak book berhasil!";
    }

    public function attachWhere()
    {
        $author = Author::where('nama', "Eko Mulyani")->first();
        $book = Book::where('isbn', [9795264662729, 9789741002184])->get();

        $author->books()->attach($book);

        echo "Proses attach berhasil!";
    }

    public function tampil()
    {
        $author = Author::where('name', "Kani Waskita")->first();
        dump($author->books);

        foreach ($author->books as $i => $row) {
            echo ++$i . ".) {$row->isbn} | {$row->title} <br>";
        }
    }

    public function withCount()
    {
        $author = Author::withCount('books')->get();

        foreach ($author as $i => $row) {
            echo ++$i . ".) Penulis {$row->name} berkolaboratif sebanyak {$row->books_count} <br>";
        }
    }

    public function detach()
    {
        // memutuskan hubungan
        $author = Author::where('name', "Fathonah Hutasoit")->first();
        $book = Book::where('title', "Ronggeng Dukuh Paruk")->first();

        $author->books()->detach($book);

        echo "Proses detach berhasil!";
    }

    public function show()
    {
        // Menampillkan author yang setidaknya menulis 1 buku atau lebih
        $author = Author::has('books')->get();

        foreach ($author as $row) {
            echo "Penulis {$row->name} telah menulis buku : <ul>";
            foreach ($row->books as $col) {
                echo "<li>{$col->title}</li>";
            }
            echo "</ul>";
        }
    }

    public function sync()
    {
        // Method sync() juga dipakai untuk menginput hubungan relationship, tapi setiap kali method ini dijalankan, hubungan yang sudah ada akan dihapus terlebih dahulu
        $author = Author::where('name', "Kani Waskita")->first();
        $books = Book::find([2, 4, 5]);

        $author->books()->sync($books);

        echo "Proses sync berhasil!";
    }

    public function syncChaining()
    {
        Author::where('name', "Kani Waskita")->first()->books()->sync(Book::find([3, 4]));
        echo "Proses sync chaining berhasil!";
    }

    public function syncWithoutDetaching()
    {
        // Jika sync saja maka akan menghapus data sebelumnya, maka jika menggunakan syncWithoutDetaching maka data sebelumnya tidak akan terhapus

        Author::where('name', "Kani Waskita")->first()->books()->syncWithoutDetaching(Book::find([1, 5]));

        echo "Proses sync without detaching berhasil!";

        // Bedanya attach() jika kita menambah data yang sama maka data tersebut tidak akan ditambahkan alias data tidak akan berganda
    }

    public function toggle()
    {
        Author::where('name', "Kani Waskita")->first()->books()->toggle(Book::find(2));

        echo "Toggle data Kani Waskita berhasil!";
    }

    public function delete()
    {
        Author::where('name', "Kani Waskita")->first()->delete();

        echo "Data Kani Waskita berhasil di hapus!";
    }
}