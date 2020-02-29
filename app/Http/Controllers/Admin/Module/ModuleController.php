<?php

namespace App\Http\Controllers\Admin\Module;

use App\Http\Controllers\Controller;

class ModuleController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.module.index');
    }
}
