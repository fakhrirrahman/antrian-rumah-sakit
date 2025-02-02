<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AntrianController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AntrianController::class, 'showForm'])->name('ambil-antrian');
Route::post('/ambil-antrian', [AntrianController::class, 'store'])->name('ambil-antrian.store');
Route::get('/antrian-berjalan', [AntrianController::class, 'antrianBerjalan'])->name('antrian.berjalan');
Route::get('/api/antrian-berjalan', [AntrianController::class, 'getAntrianBerjalan']);
