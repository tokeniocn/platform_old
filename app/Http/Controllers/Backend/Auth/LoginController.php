<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function index()
    {
        return view('backend.auth.login');
    }
}
