<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClaseVehiculo;
use App\Models\Combustible;
use App\Models\Vehiculo;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class VehiculoApiController extends Controller
{
    public function vehicleRegister(Request $request)
    {
        $claseVehiculo  = ClaseVehiculo::where('tipo', $request->clase_vehiculo)->first();
        $combustible    = Combustible::where('tipo', $request->combustible)->first();
        if (($claseVehiculo instanceof ClaseVehiculo) &&
            ($combustible instanceof Combustible)
        ) {
            try {
                $vehiculo = new Vehiculo();
                $vehiculo->user_id              = $request->user_id;
                $vehiculo->clases_vehiculo_id   = $claseVehiculo->id;
                $vehiculo->combustible_id       = $combustible->id;
                $vehiculo->placa                = $request->placa;
                $vehiculo->marca                = $request->marca;
                $vehiculo->modelo               = $request->modelo;
                $vehiculo->color                = $request->color;
                $vehiculo->cilindraje           = $request->cilindraje;
                $vehiculo->fecha_inicio_SOAT    = (new Carbon($request->fecha_inicio_SOAT))->format('d/m/y');
                $vehiculo->fecha_fin_SOAT       = (new Carbon($request->fecha_fin_SOAT))->format('d/m/y');
                $vehiculo->fecha_inicio_tecno   = (new Carbon($request->fecha_inicio_tecno))->format('d/m/y');
                $vehiculo->fecha_fin_tecno      = (new Carbon($request->fecha_fin_tecno))->format('d/m/y');
                $vehiculo->save();
                return response()->json(['id' => $vehiculo->id, 'status' => 'success'], 201);
            } catch (Exception $e) {
                return response()->json(['message' => 'Error en registro: '.$e->getMessage(), "status" => "invalid"], 500);
            }

        }
        return response()->json(['message' => 'Error en registro', "status" => "invalid"], 500);
    }
}
