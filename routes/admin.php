<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminKategoriController;
use App\Http\Controllers\Admin\AdminKegiatanController;
use App\Http\Controllers\Admin\AdminKeuanganController;
use App\Http\Controllers\Admin\AdminMusalaController;
use App\Http\Controllers\Admin\AdminUserController;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('kategori', AdminKategoriController::class)->except(['show']);
    Route::resource('kegiatan', AdminKegiatanController::class)->except(['show']);
    Route::resource('users', AdminUserController::class)->except(['show']);

    Route::prefix('keuangan')->name('keuangan.')->group(function () {
        Route::get('/', [AdminKeuanganController::class, 'index'])->name('index');

        Route::get('/setor', [AdminKeuanganController::class, 'createDeposit'])->name('deposit.create');
        Route::post('/setor', [AdminKeuanganController::class, 'storeDeposit'])->name('deposit.store');

        Route::get('/ambil', [AdminKeuanganController::class, 'createWithdraw'])->name('withdraw.create');
        Route::post('/ambil', [AdminKeuanganController::class, 'storeWithdraw'])->name('withdraw.store');

        Route::get('/kas/pengeluaran', [AdminKeuanganController::class, 'createKasExpense'])->name('kas.expense.create');
        Route::post('/kas/pengeluaran', [AdminKeuanganController::class, 'storeKasExpense'])->name('kas.expense.store');

        Route::post('/{transaction}/approve', [AdminKeuanganController::class, 'approve'])->name('approve');
        Route::post('/{transaction}/reject', [AdminKeuanganController::class, 'reject'])->name('reject');
    });

    Route::prefix('admin/musala')->group(function () {
        Route::get('/', [AdminMusalaController::class, 'index'])->name('musala.index');
        Route::get('/{slug}/edit', [AdminMusalaController::class, 'edit'])->name('musala.edit');
        Route::post('/{slug}', [AdminMusalaController::class, 'update'])->name('musala.update');
    });
});