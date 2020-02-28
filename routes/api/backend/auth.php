<?php

use App\Http\Controllers\Backend\Api\Auth\RoleController;
use App\Http\Controllers\Backend\Api\Auth\PermissionController;


// All route names are prefixed with 'admin.api.auth'.
Route::group([
    'namespace' => 'Auth',
    'as'        => 'auth.',
], function () {

    Route::group(['prefix' => 'v1/auth', 'middleware' => ['admin', 'role:admin']], function () {


        Route::get('permissions', [PermissionController::class, 'index'])->name('permissions');


        Route::get('roles', [RoleController::class, 'index'])->name('roles');
        Route::post('roles', [RoleController::class, 'store'])->name('role.store');
        Route::group(['prefix' => 'roles/{role}'], function () {
            Route::get('/', [RoleController::class, 'withPermissions'])->name('role');
            Route::put('/', [RoleController::class, 'update'])->name('role.update');
            Route::delete('/', [RoleController::class, 'destroy'])->name('role.destroy');
        });
    });
});
