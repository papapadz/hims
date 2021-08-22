<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Employees;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'admin',
            'password' => bcrypt('password'),
            'user_id' => 'MED190002',
            'account_type' => 1
        ]);
    }
}
