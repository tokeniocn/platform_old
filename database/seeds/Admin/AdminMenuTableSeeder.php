<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\AdminMenu;

class AdminMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $system = AdminMenu::create([
            'title' => '系统',
            'icon' => 'icon-set',
            'url' => '',
            'is_show' => 1,
        ]);

        $menu = AdminMenu::create([
            'title' => '菜单',
            'parent_id' => $system->id,
            'url' => route('admin.system.menu', [], false),
            'is_show' => 1,
        ]);
    }
}
