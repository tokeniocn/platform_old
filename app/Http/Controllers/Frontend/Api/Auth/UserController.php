<?php

namespace App\Http\Controllers\Frontend\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function info(Request $request)
    {
        return $request->user();
    }
}
