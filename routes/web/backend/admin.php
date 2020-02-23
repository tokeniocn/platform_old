<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\WelcomeController;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('welcome', [WelcomeController::class, 'index'])->name('welcome');
