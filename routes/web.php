<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PetaController;
use App\Http\Controllers\RealisasiTargetController;
use App\Http\Controllers\PenggunaanPajakController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\CekPbbController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\AuthController;

// Direct route & fallback for auth.php
Route::get('/auth.php', function () {
    return redirect()->route('login');
})->name('auth.php');

// Include dedicated authentication routes file
require __DIR__ . '/auth.php';

// Main Application Routes
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Peta PBB-P2 (All 30 Kecamatan & Detail Desa)
Route::get('/peta', [PetaController::class, 'index'])->name('peta.index');
Route::get('/peta/kecamatan/{id}', [PetaController::class, 'kecamatan'])->name('peta.kecamatan');

// Realisasi & Target
Route::get('/realisasi', [RealisasiTargetController::class, 'index'])->name('realisasi.index');

// Penggunaan Pajak
Route::get('/penggunaan', [PenggunaanPajakController::class, 'index'])->name('penggunaan.index');
Route::get('/penggunaan/download', [PenggunaanPajakController::class, 'download'])->name('penggunaan.download');

// Informasi
Route::get('/informasi', [InformasiController::class, 'index'])->name('informasi.index');
Route::get('/informasi/{id}', [InformasiController::class, 'show'])->name('informasi.show');

// Cek PBB Online
Route::get('/cek-pbb', [CekPbbController::class, 'index'])->name('cek-pbb.index');
Route::post('/cek-pbb/bayar/{id}', [CekPbbController::class, 'bayar'])->name('cek-pbb.bayar');

// Pengaturan & Keamanan
Route::get('/pengaturan/users', [PengaturanController::class, 'users'])->name('pengaturan.users');
Route::get('/pengaturan/keamanan', [PengaturanController::class, 'keamanan'])->name('pengaturan.keamanan');
