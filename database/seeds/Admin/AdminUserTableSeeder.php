<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\Adminuser;

class AdminUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = AdminUser::create([
            'username' => 'admin',
            'password' => 'admin',
            'active' => 1,
        ]);

        $admin->assignRole('admin');
    }
}
