<?php

namespace Database\Seeders;

use App\Models\ClaseVehiculo;
use Illuminate\Database\Seeder;

class ClasesVehiculoSeeder extends Seeder
{

    public function run()
    {
        $claseVehiculo = new ClaseVehiculo();
        $claseVehiculo->tipo = 'Moto';
        $claseVehiculo->save();

        $claseVehiculo = new ClaseVehiculo();
        $claseVehiculo->tipo = 'Carro';
        $claseVehiculo->save();

        $claseVehiculo = new ClaseVehiculo();
        $claseVehiculo->tipo = 'Bus';
        $claseVehiculo->save();

        $claseVehiculo = new ClaseVehiculo();
        $claseVehiculo->tipo = 'Motocarro';
        $claseVehiculo->save();

        $claseVehiculo = new ClaseVehiculo();
        $claseVehiculo->tipo = 'Cuatrimoto';
        $claseVehiculo->save();

    }
}
