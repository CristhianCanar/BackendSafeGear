<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $user = new User();
        $user->rol_id = 1;
        $user->nombre = 'Juan';
        $user->email = 'juan@gmail.com';
        $user->password = Hash::make('juan0000');
        $user->save();

        $user = new User();
        $user->rol_id = 2;
        $user->nombre = 'Tony';
        $user->nombre = 'Stark';
        $user->email = 'tony@gmail.com';
        $user->password = Hash::make('tony0000');
        $user->save();
    }
}
