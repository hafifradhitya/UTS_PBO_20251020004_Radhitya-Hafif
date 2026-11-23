<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JadwalController;

Route::get('/', function () {
    return redirect()->route('jadwal.dashboard');
});

Route::get('/dashboard', [JadwalController::class, 'dashboard'])->name('jadwal.dashboard');
Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
Route::get('/jadwal/{kode}', [JadwalController::class, 'show'])->name('jadwal.show');
Route::get('/jadwal/{kode}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
Route::match(['PUT', 'PATCH'], '/jadwal/{kode}', [JadwalController::class, 'update'])->name('jadwal.update');
Route::delete('/jadwal/{kode}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
