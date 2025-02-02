<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AntrianController;
use App\Http\Controllers\PoliUmumController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AntrianController::class, 'showForm'])->name('ambil-antrian');
Route::post('/ambil-antrian', [AntrianController::class, 'store'])->name('ambil-antrian.store');
Route::get('/antrian-berjalan', [AntrianController::class, 'antrianBerjalan'])->name('antrian.berjalan');
Route::get('/api/antrian-berjalan', [AntrianController::class, 'getAntrianBerjalan']);


Route::get('/ambil-antrian-poli', [PoliUmumController::class, 'showForm'])->name('ambil-antrian');
Route::post('/ambil-antrian', [PoliUmumController::class, 'store'])->name('store-antrian');

Route::get('/antrian-berjalan', [PoliUmumController::class, 'antrianBerjalan'])->name('antrian-berjalan');
Route::get('/get-antrian-berjalan', [PoliUmumController::class, 'getAntrianBerjalan'])->name('get-antrian-berjalan');
