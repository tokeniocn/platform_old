<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AdminMenu;

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
        return view('admin.dashboard', [
            'menu' => AdminMenu::menu(),
            'defaultPage' => url('/admin/welcome')
        ]);
    }
}
