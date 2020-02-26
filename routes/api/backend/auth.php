<?php

use App\Http\Controllers\Backend\Api\Auth\RoleController;
use App\Http\Controllers\Backend\Api\Auth\PermissionController;


// All route names are prefixed with 'admin.api.auth'.
Route::group([
    'namespace' => 'Auth',
    'as'        => 'auth.',
], function () {

    Route::group(['prefix' => 'v1/auth', 'middleware' => ['admin', 'role:admin']], function () {

        Route::get('roles', [RoleController::class, 'index'])->name('roles');
        Route::get('roles/{role}/permissions', [RoleController::class, 'withRole'])->name('role.permissions');
        Route::get('permissions', [PermissionController::class, 'index'])->name('permissions');


        Route::group(['prefix' => 'role/{role}'], function () {
            Route::get('edit', [RoleController::class, 'edit'])->name('role.edit');
            Route::patch('/', [RoleController::class, 'update'])->name('role.update');
            Route::delete('/', [RoleController::class, 'destroy'])->name('role.destroy');
        });
    });
});
