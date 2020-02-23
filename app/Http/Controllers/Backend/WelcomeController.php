<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.welcome');
    }
}
