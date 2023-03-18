<?php

namespace Database\Seeders;

use App\Models\Combustible;
use Illuminate\Database\Seeder;

class CombustiblesTableSeeder extends Seeder
{

    public function run()
    {
        $combustible = new Combustible();
        $combustible->tipo = 'Gasolina corriente';
        $combustible->save();

        $combustible = new Combustible();
        $combustible->tipo = 'Gasolina premium';
        $combustible->save();

        $combustible = new Combustible();
        $combustible->tipo = 'Diesel';
        $combustible->save();
    }
}
