<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rol = new Rol();
        $rol->rol = 'Usuario';
        $rol->save();

        $rol = new Rol();
        $rol->rol = 'Mecánico';
        $rol->save();

    }
}
