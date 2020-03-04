<?php

use App\Http\Controllers\Admin\Api\Media\UploadController;

Route::group([
    'prefix' => 'v1/media',
    'as' => 'media.',
    'namespace' => 'Media',
], function () {
    Route::post('upload', [UploadController::class, 'index'])->name('upload');
});
