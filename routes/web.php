<?php

use App\Http\Controllers\LanguageController;

/*
 * Global Routes
 * Routes that are used between both frontend and admin.
 */

// Switch between the included languages
Route::get('lang/{lang}', [LanguageController::class, 'swap']);

/*
 * Frontend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    include_route_files(__DIR__.'/web/frontend/');
});


Route::group(['middleware' => 'default_guard:admin'], function() {
    /*
     * Admin Routes
     * Namespaces indicate folder structure
     */
    Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
        /*
         * These routes need view-admin permission
         * (good if you want to allow more than one group in the admin,
         * then limit the admin features by different roles or permissions)
         *
         * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
         * These routes can not be hit if the password is expired
         */
        include_route_files(__DIR__.'/web/admin/');
    });


    /*
     * Admin Api Routes
     * Namespaces indicate folder structure
     */
    Route::group(['namespace' => 'Admin\Api', 'prefix' => 'admin/api', 'as' => 'admin.api.', 'middleware' => 'api'], function () {
        /*
         * These routes need view-admin permission
         * (good if you want to allow more than one group in the admin,
         * then limit the admin features by different roles or permissions)
         *
         * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
         * These routes can not be hit if the password is expired
         */
        include_route_files(__DIR__.'/api/admin/');
    });
});

