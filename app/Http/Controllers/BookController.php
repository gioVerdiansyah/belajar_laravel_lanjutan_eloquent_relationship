<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function all()
    {
        $books = Book::all();

        foreach ($books as $i => $row) {
            echo ++$i . ".) {$row->isbn} | {$row->title} <br>";
        }
    }

    public function attach()
    {
        $book = Book::find(2);
        $author = Author::find(4);

        $book->authors()->attach($author);
        echo "Proses attach berhasil!";
    }

    public function attachWhere()
    {
        $book = Book::where('title', "Laskar Pelangi")->first();
        $authors = Author::where('name', "LIKE", "%ai%")->get();

        $book->authors()->attach($authors);
        echo "Proses attach where berhasil!";
    }

    public function tampil()
    {
        $books = Book::where('title', "Laskar Pelangi")->first();

        echo "Penulis-penulis yang berkolaborasi dengan buku Laskar Pelangi : <br>";
        foreach ($books->authors as $i => $row) {
            echo ++$i . ".) {$row->name} <br>";
        }
    }

    public function show()
    {
        $book = Book::has('authors')->get();

        foreach ($book as $row) {
            echo "Buku {$row->title} di tulis/kolaborasi oleh: <ul>";
            foreach ($row->authors as $col) {
                echo "<li>{$col->name}</li>";
            }
            echo "</ul>";
        }
    }

    public function detach()
    {
        $book = Book::where('title', "Ronggeng Dukuh Paruk")->firstOrFail();
        $author = Author::where('name', "Tari Kusmawati")->firstOrFail();

        $book->authors()->detach($author);
        echo "Proses detach berhasil!";
    }

    public function sync()
    {
        Book::find(4)->authors()->sync(Author::find([1, 2, 3]));
        echo "Proses sync berhasil!";
    }

    public function pivot()
    {
        $books = Book::where('title', "Laskar Pelangi")->first();
        echo "#=== Daftar kobalorasi buku {$books->title}: <br>";

        foreach ($books->authors as $row) {
            echo "{$row->name} berkolaborasi pada {$row->pivot->created_at->isoFormat('D MMMM Y')} <br>";
        }
    }
}