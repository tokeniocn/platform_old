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
        settings('a');
        return 'hello world!';
    }
}
