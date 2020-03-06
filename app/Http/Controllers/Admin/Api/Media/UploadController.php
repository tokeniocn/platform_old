<?php

namespace App\Http\Controllers\Admin\Api\Media;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Media\UploadRequest;
use MediaUploader;

class UploadController extends Controller
{

    public function index(UploadRequest $request)
    {
        $media = tap(MediaUploader::fromSource($request->file('file')), function ($uploader) use ($request) {
            $uploader->beforeSave(function ($model, $source) use ($uploader, $request) {
                $model->uid = $request->user()->id;
                $model->original_filename = str_replace(['#', '?', '\\', '/'], '-', $source->filename());

            });
        })
            ->useHashForFilename()
            ->upload();

        return $media;
    }
}
