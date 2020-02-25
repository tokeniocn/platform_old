<?php

namespace App\Http\Controllers\Backend\Api\System;

use App\Http\Controllers\Controller;
use App\Models\System\AdminMenu;

class MenuController extends Controller
{
    public function index()
    {
        return AdminMenu::menu();
    }
}
