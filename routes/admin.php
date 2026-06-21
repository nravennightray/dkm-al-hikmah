<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminKategoriController;
use App\Http\Controllers\Admin\AdminKegiatanController;
use App\Http\Controllers\Admin\AdminUserController;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('kategori', AdminKategoriController::class)->except(['show']);
    Route::resource('kegiatan', AdminKegiatanController::class)->except(['show']);
    Route::resource('users', AdminUserController::class)->except(['show']);
});