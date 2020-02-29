<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    public function index()
    {
        return view('admin.system.menu');
    }
}
