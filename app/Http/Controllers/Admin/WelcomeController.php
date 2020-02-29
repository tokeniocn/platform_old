<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.welcome');
    }
}
