<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\AdminMenu;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.dashboard', [
            'menu' => AdminMenu::menu(),
            'defaultPage' => url('/admin/welcome')
        ]);
    }
}
