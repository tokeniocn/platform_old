<?php

// All route names are prefixed with 'admin.'.
Route::group(['middleware' => ['admin']], function () {
    Route::redirect('/', '/admin/dashboard', 301);
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('welcome', 'WelcomeController@index')->name('welcome');
});
