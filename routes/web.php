<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\AuthController;

// Root URL mengalihkan ke dashboard (sesuai kontrak Skill.md)
Route::get('/', function () {
    return redirect()->route('jadwal.dashboard');
});

// Autentikasi Sesi BAAK UCIC
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Inti UTS Jadwal Perkuliahan Mahasiswa (7 Method + Dashboard Wajib)
Route::get('/dashboard', [JadwalController::class, 'dashboard'])->name('jadwal.dashboard');
Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
Route::get('/jadwal/{kode}', [JadwalController::class, 'show'])->name('jadwal.show');
Route::get('/jadwal/{kode}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
Route::match(['PUT', 'PATCH'], '/jadwal/{kode}', [JadwalController::class, 'update'])->name('jadwal.update');
Route::delete('/jadwal/{kode}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');

// Modul Ekstra Pendukung Akademik BAAK UCIC (Dosen, Ruangan, Kelas)
Route::get('/dosen', [JadwalController::class, 'dosen'])->name('jadwal.dosen');
Route::get('/ruangan', [JadwalController::class, 'ruangan'])->name('jadwal.ruangan');
Route::get('/kelas', [JadwalController::class, 'kelas'])->name('jadwal.kelas');
