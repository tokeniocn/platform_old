<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminPermissionTableSeeder extends Seeder
{
    use DisableForeignKeys;

    public function run()
    {
        $this->disableForeignKeys();

        // Create Roles
        Role::create([
            'name' => 'admin',
            'guard_name' => 'admin'
        ]);

        // Create Permissions
        Permission::create([
            'name' => 'view backend',
            'guard_name' => 'admin'
        ]);

        // Assign Permissions to other Roles
        // Note: Admin (User 1) Has all permissions via a gate in the AuthServiceProvider
        // $user->givePermissionTo('view backend');

        $this->enableForeignKeys();
    }
}
