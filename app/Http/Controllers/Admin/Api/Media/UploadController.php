<?php

namespace App\Http\Controllers\Admin\Api\Media;

use MediaUploader;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Media\UploadRequest;

class UploadController extends Controller
{

    public function index(UploadRequest $request)
    {
        $media = MediaUploader::fromSource($request->file('file'))
            ->upload();
    }
}
