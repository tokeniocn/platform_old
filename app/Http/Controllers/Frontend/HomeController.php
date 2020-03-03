<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

/**
 * Class HomeController.
 */
class HomeController extends Controller
{

    public function index()
    {
        return route('frontend.api.auth.login');
        return 'hello world!';
    }
}
