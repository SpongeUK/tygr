<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;

class UserTableSeeder extends Seeder {

    public function run()
    {
        User::create(array(
            'name'        => 'Jamie Shepherd',
            'client'   => null,
            'level'       => 1,
            'email'       => 'jamie.shepherd@outlook.com',
            'password'    => Hash::make('password')
        ));
        User::create(array(
            'name'        => 'Test User',
            'client'   => 1,
            'level'       => 3,
            'email'       => 'test@user.com',
            'password'    => Hash::make('password')
        ));
    }

}