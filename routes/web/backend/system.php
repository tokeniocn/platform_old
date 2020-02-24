<?php

Route::group([
    'prefix' => 'system',
    'as' => 'system.',
    'namespace' => 'System',
    'middleware' => 'role:'.config('access.users.admin_role'),
], function () {
    Route::get('menu', 'MenuController@index')->name('menu');
});

