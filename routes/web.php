<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AntrianController;
use App\Http\Controllers\PoliUmumController;
use App\Http\Controllers\FarmasiController;


//poli gigi
Route::get('/', [AntrianController::class, 'showForm'])->name('ambil-antrian');
Route::post('/ambil-antrian', [AntrianController::class, 'store'])->name('ambil-antrian.store');
Route::get('/antrian-berjalan', [AntrianController::class, 'antrianBerjalan'])->name('antrian.berjalan');
Route::get('/api/antrian-berjalan', [AntrianController::class, 'getAntrianBerjalan']);

//poli umum
Route::get('/ambil-antrian-poliUmum', [PoliUmumController::class, 'showForm'])->name('ambil-antrian-poliUmum');
Route::post('/ambil-antrian-poliUmum', [PoliUmumController::class, 'store'])->name('store-antrian-PoliUmum');
Route::get('/antrian-berjalan-poliUmum', [PoliUmumController::class, 'antrianBerjalan'])->name('antrian-berjalan-poliUmum');
Route::get('/api/get-antrian-berjalan-PoliUmum', [PoliUmumController::class, 'getAntrianBerjalanPoliUmum']);

//farmasi
Route::get('/ambil-antrian-farmasi', [FarmasiController::class, 'showForm'])->name('ambil-antrian-farmasi');
Route::post('/ambil-antrian-farmasi', [FarmasiController::class, 'store'])->name('ambil-antrian-farmasi.store');
Route::get('/antrian-berjalan-farmasi', [FarmasiController::class, 'antrianBerjalan'])->name('antrian.berjalan');
Route::get('/api/antrian-berjalan-farmasi', [FarmasiController::class, 'getAntrianBerjalan']);
