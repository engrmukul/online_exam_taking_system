<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);

        $users = [
            'id' => 1,
            'name' => 'mukul',
            'mobile' => '01734183130',
            'username' => 'mukul',
            'email' => 'mukul@gmail.com',
            'email_verified_at' => null,
            'password' => bcrypt(123456),
            'role' => 'system_admin',
            'remember_token' => null,
            'last_login' => date('Y-m-d H:i:s'),
            'status' => 'active',
            'created_by' => 1

        ];

        \App\Models\User::create($users);
    }
}
