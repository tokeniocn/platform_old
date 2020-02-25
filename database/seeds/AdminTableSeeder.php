<?php

use Illuminate\Database\Seeder;

/**
 * Class AdminTableSeeder.
 */
class AdminTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run()
    {
        $this->call(AdminPermissionTableSeeder::class);
        $this->call(AdminUserTableSeeder::class);
        $this->call(AdminMenuTableSeeder::class);
    }
}
