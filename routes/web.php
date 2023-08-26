<?php

use App\Models\Siswas;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// ! Has One
use App\Http\Controllers\MahasiswaController;

Route::prefix('/mahasiswa')->group(function () {
    Route::get('/all', [MahasiswaController::class, 'all']);
    Route::get('/gabung-1', [MahasiswaController::class, 'gabung1']);
    Route::get('/gabung-2', [MahasiswaController::class, 'gabung2']);
    Route::get('/gabung-join-1', [MahasiswaController::class, 'gabungJoin1']);

    Route::get('/gabung-join-2', [MahasiswaController::class, 'gabungJoin2']);
    Route::get('/gabung-join-3', [MahasiswaController::class, 'gabungJoin3']);

    // ! Eloquent Relationship hasOne()
    Route::get('/find', [MahasiswaController::class, 'find']);
    Route::get('/where', [MahasiswaController::class, 'where']);
    Route::get('/where-chaining', [MahasiswaController::class, 'whereChaining']);
    Route::get('/all-join', [MahasiswaController::class, 'allJoin']);
    Route::get('/has', [MahasiswaController::class, 'has']);
    Route::get('/where-has', [MahasiswaController::class, 'whereHas']);
    Route::get('/doesnt-have', [MahasiswaController::class, 'doesntHave']);
    Route::get('/where-doesnt-have', [MahasiswaController::class, 'whereDoesntHave']);

    Route::get('/insert-save', [MahasiswaController::class, 'insertSave']);
    Route::get('/insert-create', [MahasiswaController::class, 'insertCreate']);

    Route::get('/update', [MahasiswaController::class, 'update']);
    Route::get('/update-push', [MahasiswaController::class, 'updatePush']);
    Route::get('/update-push-where', [MahasiswaController::class, 'updatePushWhere']);

    Route::get('/delete-find', [MahasiswaController::class, 'deleteFind']);
    Route::get('/delete-where', [MahasiswaController::class, 'deleteWhere']);
    Route::get('/delete-if', [MahasiswaController::class, 'deleteIf']);
    Route::get('/delete-cascade', [MahasiswaController::class, 'deleteCascade']);
    Route::get('/update-cascade', [MahasiswaController::class, 'updateCascade']);
});

// ! Belongs To
use App\Http\Controllers\NilaiController;

Route::prefix('/nilai')->group(function () {
    Route::get('/find', [NilaiController::class, 'find']);
    Route::get('/where', [NilaiController::class, 'where']);
    Route::get('/where-chaining', [NilaiController::class, 'whereChaining']);
    Route::get('/has', [NilaiController::class, 'has']);
    Route::get('/has-eager', [NilaiController::class, 'hasEager']);

    Route::get('/test-input-1', [NilaiController::class, 'testInput1']);
    Route::get('/test-input-2', [NilaiController::class, 'testInput2']);
    Route::get('/test-input-3', [NilaiController::class, 'testInput3']);
    Route::get('/test-input-4', [NilaiController::class, 'testInput4']);

    Route::get('/associate-new', [NilaiController::class, 'associateNew']);
    Route::get('/associate-find', [NilaiController::class, 'associateFind']);

    Route::get('/delete', [NilaiController::class, 'delete']);
    Route::get('/delete-mahasiswa', [NilaiController::class, 'deleteMahasiswa']);
});


use App\http\Controllers\JurusanController as Jurusan;

Route::prefix('/jurusan')->group(function () {
    Route::get('/all', [Jurusan::class, 'all']);
    Route::get('/gabung', [Jurusan::class, 'gabung']);
    Route::get('/gabung-join', [Jurusan::class, 'gabungJoin']);

    //! has many
    Route::get('/find', [Jurusan::class, 'find']);
    Route::get('/where', [Jurusan::class, 'where']);
    Route::get('/join-all', [Jurusan::class, 'joinAll']);
    Route::get('/has', [Jurusan::class, 'has']);
    Route::get('/where-has', [Jurusan::class, 'whereHas']);
    Route::get('/doesnt-have', [Jurusan::class, 'doesntHave']);
    Route::get('/with-count', [Jurusan::class, 'withCount']);
    Route::get('/load-count', [Jurusan::class, 'loadCount']);
    Route::get('/insert-save', [Jurusan::class, 'insertSave']);
    Route::get('/insert-create', [Jurusan::class, 'insertCreate']);
    Route::get('/insert-create-many', [Jurusan::class, 'insertCreateMany']);
    Route::get('/update', [Jurusan::class, 'update']);
    Route::get('/update-push', [Jurusan::class, 'updatePush']);
    Route::get('/delete', [Jurusan::class, 'delete']);
});

// ! Belongs To
use App\Http\Controllers\SiswasController as Siswa;

Route::prefix('/siswa')->group(function () {
    Route::get('/find', [Siswa::class, 'find']);
    Route::get('/where', [Siswa::class, 'where']);
    Route::get('/where-chaining', [Siswa::class, 'whereChaining']);
    Route::get('/has', [Siswa::class, 'has']);
    Route::get('/where-has', [Siswa::class, 'whereHas']);
    Route::get('/doesnt-have', [Siswa::class, 'doesntHave']);
    Route::get('/associate', [Siswa::class, 'associate']);
    Route::get('/associate-update', [Siswa::class, 'associateUpdate']);
    Route::get('/delete', [Siswa::class, 'delete']);
    Route::get('/dissociate', [Siswa::class, 'dissociate']);
    Route::get('/associate-kembali', [Siswa::class, 'associateKembali']);
});

Route::get('/test', App\Http\Controllers\Test::class);


// ! Many to Many
// ! Belongs to Many
use App\Http\Controllers\AuthorController as Author;

Route::prefix('/author')->group(function () {
    Route::get('/all', [Author::class, 'all']);
    Route::get('/attach', [Author::class, 'attach']);
    Route::get('/attach-array', [Author::class, 'attachArray']);
    Route::get('/tampil', [Author::class, 'tampil']);
    Route::get('/with-count', [Author::class, 'withCount']);
    Route::get('/detach', [Author::class, 'detach']);
    Route::get('/show', [Author::class, 'show']);
    Route::get('/sync', [Author::class, 'sync']);
    Route::get('/sync-chaining', [Author::class, 'syncChaining']);
    Route::get('/sync-without-detaching', [Author::class, 'syncWithoutDetaching']);
    Route::get('/toggle', [Author::class, 'toggle']);
    Route::get('/delete', [Author::class, 'delete']);
});

// ! Belongs to Many lagi
use App\Http\Controllers\BookController as Book;

Route::prefix('/book')->group(function () {
    Route::get('/all', [Book::class, "all"]);
    Route::get('/attach', [Book::class, "attach"]);
    Route::get('/attach-where', [Book::class, "attachWhere"]);
    Route::get('/tampil', [Book::class, "tampil"]);
    Route::get('/show', [Book::class, "show"]);
    Route::get('/detach', [Book::class, "detach"]);
    Route::get('/sync', [Book::class, "sync"]);
    Route::get('/pivot', [Book::class, "pivot"]);
});

// ! Has One Through
use App\Http\Controllers\StudentController as Student;

Route::prefix('/student')->group(function () {
    Route::get('/all', [Student::class, 'all']);
    Route::get('/relationship-1', [Student::class, 'relationship1']);
    Route::get('/relationship-2', [Student::class, 'relationship2']);
    Route::get('/relationship-3', [Student::class, 'relationship3']);
    Route::get('/input', [Student::class, 'input1']);
    Route::get('/input-2', [Student::class, 'input2']);
    Route::get('/update', [Student::class, 'update']);
    Route::get('/delete', [Student::class, 'delete']);
});

// ! Belongs to Through
// Install pihak ke 3 unutk Belongs to Through
// composer require staudenmeir/belongs-to-through:"^2.5"
use App\Http\Controllers\AcademicController as Academic;

Route::prefix('/academic')->group(function () {
    Route::get('all', [Academic::class, 'all']);
    Route::get('test-belongs-to-through', [Academic::class, 'belongsToThrough']);
    Route::get('relationship-1', [Academic::class, 'relationship1']);
    Route::get('relationship-2', [Academic::class, 'relationship2']);
    Route::get('create', [Academic::class, 'create']);
    Route::get('create-2', [Academic::class, 'create2']);
    Route::get('update', [Academic::class, 'update']);
    Route::get('delete', [Academic::class, 'delete']);
});

// ! Has Many Through

use App\Http\Controllers\FacultyController as Faculty;

Route::prefix('/faculty')->group(function () {
    Route::get('/all', [Faculty::class, 'all']);
    Route::get('/relationship-1', [Faculty::class, 'relationship1']);
    Route::get('/relationship-2', [Faculty::class, 'relationship2']);
    Route::get('/relationship-3', [Faculty::class, 'relationship3']);
    Route::get('/count', [Faculty::class, 'count']);
});