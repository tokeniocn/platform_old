<?php

namespace App\Http\Controllers\Backend\Module;

use App\Http\Controllers\Controller;

class ModuleController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.module.index');
    }
}
