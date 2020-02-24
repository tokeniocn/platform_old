<?php

namespace App\Http\Controllers\Backend\System;

use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    public function index()
    {
        return view('backend.system.menu');
    }
}
