<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminHomeInfoController;
use App\Http\Controllers\Admin\AdminInfaqController;
use App\Http\Controllers\Admin\AdminKategoriController;
use App\Http\Controllers\Admin\AdminKegiatanController;
use App\Http\Controllers\Admin\AdminKeuanganController;
use App\Http\Controllers\Admin\AdminMusalaController;
use App\Http\Controllers\Admin\AdminProfilController;
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

        Route::get('/export', [AdminKeuanganController::class, 'export'])->name('export');
    });

    Route::prefix('musala')->name('musala.')->group(function () {
        Route::get('/', [AdminMusalaController::class, 'index'])->name('index');
        Route::get('/{slug}/edit', [AdminMusalaController::class, 'edit'])->name('edit');
        Route::post('/{slug}', [AdminMusalaController::class, 'update'])->name('update');
    });

    Route::prefix('profil')->name('profil.')->group(function () {
        Route::get('/', [AdminProfilController::class, 'index'])->name('index');

        Route::get('/{section}', [AdminProfilController::class, 'section'])->name('section.index');
        Route::get('/{section}/create', [AdminProfilController::class, 'create'])->name('section.create');
        Route::post('/{section}', [AdminProfilController::class, 'store'])->name('section.store');

        Route::get('/{section}/{id}/edit', [AdminProfilController::class, 'edit'])->name('section.edit');
        Route::post('/{section}/{id}', [AdminProfilController::class, 'update'])->name('section.update');
        Route::delete('/{section}/{id}', [AdminProfilController::class, 'destroy'])->name('section.destroy');
    });

    Route::prefix('home-info')->name('home-info.')->group(function () {
        Route::get('/', [AdminHomeInfoController::class, 'index'])->name('index');
        Route::get('/create', [AdminHomeInfoController::class, 'create'])->name('create');
        Route::post('/', [AdminHomeInfoController::class, 'store'])->name('store');

        Route::get('/{id}/edit', [AdminHomeInfoController::class, 'edit'])->name('edit');
        Route::post('/{id}', [AdminHomeInfoController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminHomeInfoController::class, 'destroy'])->name('destroy');

        Route::post('/{id}/toggle-status', [AdminHomeInfoController::class, 'toggleStatus'])->name('toggle-status');
    });

    Route::prefix('infaq')->name('infaq.')->group(function () {
        Route::get('/', [AdminInfaqController::class, 'index'])->name('index');

        Route::post('/settings', [AdminInfaqController::class, 'updateSettings'])->name('settings.update');

        Route::get('/accounts/create', [AdminInfaqController::class, 'createAccount'])->name('accounts.create');
        Route::post('/accounts', [AdminInfaqController::class, 'storeAccount'])->name('accounts.store');

        Route::get('/accounts/{id}/edit', [AdminInfaqController::class, 'editAccount'])->name('accounts.edit');
        Route::post('/accounts/{id}', [AdminInfaqController::class, 'updateAccount'])->name('accounts.update');
        Route::delete('/accounts/{id}', [AdminInfaqController::class, 'destroyAccount'])->name('accounts.destroy');

        Route::post('/accounts/{id}/toggle-status', [AdminInfaqController::class, 'toggleAccountStatus'])->name('accounts.toggle-status');
    });
});