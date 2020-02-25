<?php

use App\Http\Controllers\Backend\System\MenuController;

Route::group([
    'prefix' => 'system',
    'as' => 'system.',
    'namespace' => 'System',
    'middleware' => ['admin', 'role:'.config('access.users.admin_role')],
], function () {
    Route::get('menu', [MenuController::class, 'index'])->name('menu');
});

