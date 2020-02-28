<?php

use App\Http\Controllers\Backend\Module\ModuleController;

// Module Management
Route::group([
    'namespace' => 'Module',
    'as'        => 'module.',
    'prefix'    => 'modules'
], function () {

    Route::get('/', [ModuleController::class, 'index'])->name('modules');

});
