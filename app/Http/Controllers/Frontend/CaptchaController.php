<?php

namespace App\Http\Controllers\Frontend;

use Captcha;
use App\Http\Controllers\Controller;

class CaptchaController extends Controller
{
    public function index()
    {
        return Captcha::create('mini');
    }
}
