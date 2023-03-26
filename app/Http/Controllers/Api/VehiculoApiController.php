<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Vehicle\GetVehicleResource;
use App\Models\ClaseVehiculo;
use App\Models\Combustible;
use App\Models\Vehiculo;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehiculoApiController extends Controller
{
    public function getVehiclesByUserId(int $userId): JsonResponse
    {
        $response = response()->json(['message' => 'Error en consulta de vehiculos por usuario', "status" => "invalid"], 500);
        $vehiculos = Vehiculo::where('user_id', $userId)->get();
        if (!empty($vehiculos)) {
            $response = response()->json(GetVehicleResource::collection($vehiculos), 200);
        }
        return $response;
    }
    public function getVehicleById(int $vehicleId): JsonResponse
    {
        $response = response()->json(['message' => 'Error en consulta de vehículo', "status" => "invalid"], 500);
        $vehiculo = Vehiculo::where('id', $vehicleId)->first();
        if ($vehiculo instanceof Vehiculo) {
            $response = response()->json(new GetVehicleResource($vehiculo), 200);
        }
        return $response;
    }
    public function updateVehicle(Request $request, int $vehicleId): JsonResponse
    {
        $response = response()->json(['message' => 'Error en actualización de vehículo', "status" => "invalid"], 500);
        $vehiculo = Vehiculo::where('id', $vehicleId)->first();
        if ($vehiculo instanceof Vehiculo) {
            $claseVehiculo  = ClaseVehiculo::where('tipo', $request->clase_vehiculo)->first();
            $combustible    = Combustible::where('tipo', $request->combustible)->first();
            if (($claseVehiculo instanceof ClaseVehiculo) &&
                ($combustible instanceof Combustible)
            ) {
                try {
                    $vehiculo = Vehiculo::where('id', $vehiculo->id)->update([
                        'user_id'               => $request->user_id,
                        'combustible_id'        => $claseVehiculo->id,
                        'clases_vehiculo_id'    => $combustible->id,
                        'placa'                 => $request->placa,
                        'marca'                 => $request->marca,
                        'modelo'                => $request->modelo,
                        'color'                 => $request->color,
                        'cilindraje'            => $request->cilindraje,
                        'fecha_inicio_SOAT'     => (new Carbon($request->fecha_inicio_SOAT))->format('Y-n-j'),
                        'fecha_fin_SOAT'        => (new Carbon($request->fecha_fin_SOAT))->format('Y-n-j'),
                        'fecha_inicio_tecno'    => (new Carbon($request->fecha_inicio_tecno))->format('Y-n-j'),
                        'fecha_fin_tecno'       => (new Carbon($request->fecha_fin_tecno))->format('Y-n-j'),
                    ]);

                    if ($vehiculo) {
                        $response = response()->json(['id' => $vehicleId, 'status' => 'success'], 201);
                    } elseif (!$vehiculo) {
                        $response = response()->json(['message' => 'Error actualizar vehículo', "status" => "invalid"], 500);
                    }
                } catch (Exception $e) {
                    $response = response()->json(['message' => 'Error en actualizar: ' . $e->getMessage(), "status" => "invalid"], 500);
                }
            }
        }

        return $response;
    }
    public function storeVehicle(Request $request): JsonResponse
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
                // $vehiculo->fecha_inicio_SOAT    = (new Carbon($request->fecha_inicio_SOAT))->format('d/m/y');
                $vehiculo->fecha_inicio_SOAT    = (new Carbon($request->fecha_inicio_SOAT))->format('Y-n-j');
                $vehiculo->fecha_fin_SOAT       = (new Carbon($request->fecha_fin_SOAT))->format('Y-n-j');
                $vehiculo->fecha_inicio_tecno   = (new Carbon($request->fecha_inicio_tecno))->format('Y-n-j');
                $vehiculo->fecha_fin_tecno      = (new Carbon($request->fecha_fin_tecno))->format('Y-n-j');
                $vehiculo->save();
                return response()->json(['id' => $vehiculo->id, 'status' => 'success'], 201);
            } catch (Exception $e) {
                return response()->json(['message' => 'Error en registro: ' . $e->getMessage(), "status" => "invalid"], 500);
            }
        }
        return response()->json(['message' => 'Error en registro', "status" => "invalid"], 500);
    }

    public function deleteVehicle(int $vehicleId): JsonResponse
    {
        $response = response()->json(['message' => 'Error al eliminar el vehículo', "status" => "invalid"], 500);
        try {
            $vehicleDeleted = Vehiculo::where('id', $vehicleId)->delete();
            if($vehicleDeleted){
                $response = response()->json(['status' => 'success'], 200);
            } elseif(!$vehicleDeleted){
                $response = response()->json(['message' => 'No fue posible eliminar el vehículo', "status" => "invalid"], 400);
            }
        } catch (Exception $e) {
            $response = response()->json(['message' => 'Error al eliminar el vehículo'.$e->getMessage(), "status" => "invalid"], 500);
        }
        return $response;
    }
}
