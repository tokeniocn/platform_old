<?php

namespace App\Http\Controllers\Admin\Api\Media;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Media\UploadRequest;
use App\Models\Media;
use Illuminate\Http\Request;
use MediaUploader;

class UploadController extends Controller
{

    public function index(Request $request)
    {
        return $request->user()
            ->media()
            ->wherePivotIn('tag', ['author'])
            ->paginate();
    }

    public function upload(UploadRequest $request)
    {
        $media = tap(MediaUploader::fromSource($request->file('file')), function ($uploader) use ($request) {
            $uploader->beforeSave(function ($model, $source) use ($uploader, $request) {
                $model->original_filename = str_replace(['#', '?', '\\', '/'], '-', $source->filename());
            });
        })
            ->useHashForFilename()
            ->upload();

        $request->user()->attachMedia($media, ['author']);

        return $media;
    }
}
