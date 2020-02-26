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
        $user = AdminMenu::create([
            'title' => '用户管理',
            'icon' => 'layui-icon-user',
            'url' => '',
            'is_show' => 1,
        ]);

        $system = AdminMenu::create([
            'title' => '系统管理',
            'icon' => 'icon-set',
            'url' => '',
            'is_show' => 1,
        ]);

        $role = AdminMenu::create([
            'title' => '角色权限',
            'parent_id' => $system->id,
            'url' => route('admin.auth.role.index', [], false),
            'is_show' => 1,
        ]);
    }
}
