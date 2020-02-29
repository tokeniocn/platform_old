<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleTableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();

        // Create Roles
        Role::create(['name' => config('access.users.admin_role'), 'title' => '管理员']);
        Role::create(['name' => config('access.users.default_role'), 'title' => '普通用户']);

        // Create Permissions
        Permission::create(['name' => 'view admin', 'title' => '后台访问']);

        // Assign Permissions to other Roles
        // Note: Admin (User 1) Has all permissions via a gate in the AuthServiceProvider
        // $user->givePermissionTo('view admin');

        $this->enableForeignKeys();
    }
}
