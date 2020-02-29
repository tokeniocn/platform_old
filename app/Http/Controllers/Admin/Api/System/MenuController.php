<?php

namespace App\Http\Controllers\Admin\Api\System;

use App\Http\Controllers\Controller;
use App\Models\Admin\AdminMenu;

class MenuController extends Controller
{
    public function index()
    {
        return AdminMenu::menu();
    }
}
