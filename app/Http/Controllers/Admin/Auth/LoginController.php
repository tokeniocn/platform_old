<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;

/**
 * Class LoginController.
 */
class LoginController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }
}
