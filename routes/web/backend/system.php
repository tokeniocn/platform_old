<?php

use App\Http\Controllers\Backend\System\MenuController;

Route::group([
    'prefix' => 'system',
    'as' => 'system.',
    'namespace' => 'System',
    'middleware' => ['admin', 'role:admin'],
], function () {
    Route::get('menu', [MenuController::class, 'index'])->name('menu');
});

