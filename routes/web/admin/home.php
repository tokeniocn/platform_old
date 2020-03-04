<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\WelcomeController;

// All route names are prefixed with 'admin.'.
Route::group(['middleware' => ['admin', 'role:admin']], function () {
    Route::redirect('/', '/admin/dashboard', 301);
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('welcome', [WelcomeController::class, 'index'])->name('welcome');
});
