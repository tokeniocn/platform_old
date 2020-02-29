<?php

Route::group([
    'prefix' => 'v1/system',
    'as' => 'system.',
    'namespace' => 'System',
], function () {
    Route::get('menu', 'MenuController@index')->name('menu');


});
