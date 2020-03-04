<?php

use App\Http\Controllers\Admin\Api\Media\UploadController;

Route::group([
    'prefix' => 'v1/media',
    'as' => 'media.',
    'namespace' => 'Media',
    'middleware' => ['admin']
], function () {
    Route::post('upload', [UploadController::class, 'index'])->name('upload');
});
