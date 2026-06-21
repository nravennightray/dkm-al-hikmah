<?php

use App\Http\Controllers\Public\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

require __DIR__.'/public.php';
require __DIR__.'/admin.php';
require __DIR__.'/auth.php';