<?php

use App\Http\Controllers\Public\InfaqController;
use App\Http\Controllers\Public\KegiatanController;
use App\Http\Controllers\Public\LaporanController;
use App\Http\Controllers\Public\MusalaController;
use App\Http\Controllers\Public\ProfilController;

Route::prefix('profil')->group(function () {
    Route::get('/', [ProfilController::class, 'index'])->name('profil.index');
    Route::get('/sejarah', [ProfilController::class, 'sejarah'])->name('profil.sejarah');
    Route::get('/visi-misi', [ProfilController::class, 'visiMisi'])->name('profil.visi-misi');
    Route::get('/struktur-organisasi', [ProfilController::class, 'struktur'])->name('profil.struktur');
    Route::get('/prestasi', [ProfilController::class, 'prestasi']) ->name('profil.prestasi');
    Route::get('/prestasi/{slug}', [ProfilController::class, 'prestasiShow'])->name('profil.prestasi.show');
});

Route::prefix('kegiatan')->group(function () {
    Route::get('/', [KegiatanController::class, 'index'])->name('kegiatan.index');
    Route::get('/{category}', [KegiatanController::class, 'showCategory'])->name('kegiatan.category');
    Route::get('/{category}/{slug}', [KegiatanController::class, 'showDetail'])->name('kegiatan.detail');
});

Route::get('/laporan-keuangan', [LaporanController::class, 'index'])->name('laporan.index');

Route::get('/musala', [MusalaController::class, 'index'])->name('musala.index');
Route::get('/musala/{slug}', [MusalaController::class, 'show'])->name('musala.show');

Route::get('/infaq', [InfaqController::class, 'index'])->name('infaq.index');