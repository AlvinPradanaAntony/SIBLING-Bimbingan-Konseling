<?php

use App\Models\RekapAbsensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\KarirController;
use App\Http\Controllers\KasusController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\BimbinganController;

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
    return view('landing');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
Route::get('/siswa/{id}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
Route::put('/siswa/{id}', [SiswaController::class, 'update'])->name('siswa.update');
Route::delete('/siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');


Route::get('/karir', [KarirController::class, 'index'])->name('karir.index');
Route::post('/karir', [KarirController::class, 'store'])->name('karir.store');
Route::get('/karir/{id}/edit', [KarirController::class, 'edit'])->name('karir.edit');
Route::put('/karir/{id}', [KarirController::class, 'update'])->name('karir.update');
Route::delete('/karir/{id}', [KarirController::class, 'destroy'])->name('karir.destroy');

Route::get('/form', [FormsController::class, 'index'])->name('form.index');
Route::post('/form', [FormsController::class, 'store'])->name('form.store');
Route::get('/form/{id}/edit', [FormsController::class, 'edit'])->name('form.edit');
Route::put('/form/{id}', [FormsController::class, 'update'])->name('form.update');
Route::delete('/form/{id}', [FormsController::class, 'destroy'])->name('form.destroy');

Route::get('/bimbingan', [BimbinganController::class, 'index'])->name('bimbingan.index');
Route::post('/bimbingan', [BimbinganController::class, 'store'])->name('bimbingan.store');
Route::get('/bimbingan/{id}/edit', [BimbinganController::class, 'edit'])->name('bimbingan.edit');
Route::put('/bimbingan/{id}', [BimbinganController::class, 'update'])->name('bimbingan.update');
Route::delete('/bimbingan/{id}', [BimbinganController::class, 'destroy'])->name('bimbingan.destroy');

Route::get('/kasus', [KasusController::class, 'index'])->name('kasus.index');
Route::post('/kasus', [KasusController::class, 'store'])->name('kasus.store');
Route::get('/kasus/{id}/edit', [KasusController::class, 'edit'])->name('kasus.edit');
Route::put('/kasus/{id}', [KasusController::class, 'update'])->name('kasus.update');
Route::delete('/kasus/{id}', [KasusController::class, 'destroy'])->name('kasus.destroy');

Route::get('/prestasi', [PrestasiController::class, 'index'])->name('prestasi.index');
Route::post('/prestasi', [PrestasiController::class, 'store'])->name('prestasi.store');
Route::get('/prestasi/{id}/edit', [PrestasiController::class, 'edit'])->name('prestasi.edit');
Route::put('/prestasi/{id}', [PrestasiController::class, 'update'])->name('prestasi.update');
Route::delete('/prestasi/{id}', [PrestasiController::class, 'destroy'])->name('prestasi.destroy');

Route::get('/absensi', [RekapAbsensi::class, 'index'])->name('absensi.index');
Route::post('/absensi', [RekapAbsensi::class, 'store'])->name('absensi.store');
Route::get('/absensi/{id}/edit', [RekapAbsensi::class, 'edit'])->name('absensi.edit');
Route::put('/absensi/{id}', [RekapAbsensi::class, 'update'])->name('absensi.update');
Route::delete('/absensi/{id}', [RekapAbsensi::class, 'destroy'])->name('absensi.destroy');

Route::get('/jurusan', [JurusanController::class, 'index'])->name('jurusan.index');
Route::post('/jurusan', [JurusanController::class, 'store'])->name('jurusan.store');
Route::get('/jurusan/{id}/edit', [JurusanController::class, 'edit'])->name('jurusan.edit');
Route::put('/jurusan/{id}', [JurusanController::class, 'update'])->name('jurusan.update');
Route::delete('/jurusan/{id}', [JurusanController::class, 'destroy'])->name('jurusan.destroy');

Route::get('/users', [UsersController::class, 'index'])->name('user.index');
Route::post('/users', [UsersController::class, 'store'])->name('user.store');
Route::get('/users/{id}/edit', [UsersController::class, 'edit'])->name('user.edit');
Route::put('/users/{id}', [UsersController::class, 'update'])->name('user.update');
Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('user.destroy');
