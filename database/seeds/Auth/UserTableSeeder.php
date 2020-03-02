<?php

use App\Models\Auth\User;
use Illuminate\Database\Seeder;

/**
 * Class UserTableSeeder.
 */
class UserTableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();

        // Add the master administrator, user id of 1
        User::create([
            'username' => 'SuperAdmin',
            'email' => 'admin@admin.com',
            'password' => 'secret',
        ]);

        User::create([
            'username' => 'DefaultUser',
            'email' => 'user@user.com',
            'password' => 'secret',
        ]);

        $this->enableForeignKeys();
    }
}
