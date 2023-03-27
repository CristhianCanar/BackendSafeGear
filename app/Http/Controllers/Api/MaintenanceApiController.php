<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Maintenance\GetMaintenanceResource;
use App\Models\Mantenimiento;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MaintenanceApiController extends Controller
{

    public function getMaintenanceById(int $maintenanceId): JsonResponse
    {
        $response = response()->json(['message' => "No se encontró mantenimiento con id = $maintenanceId", 'status' => 'void'], 200);
        $maintenance = Mantenimiento::where('id', $maintenanceId)->first();
        if ($maintenance instanceof Mantenimiento) {
            $response = response()->json(new GetMaintenanceResource($maintenance), 200);
        }
        return $response;
    }

    public function getMaintenancesByVehicleId(int $vehicleId): JsonResponse
    {
        $response = response()->json(['message' => "No se encontraron mantenimientos para vehículo con id = $vehicleId" , 'status' => 'void'], 200);
        $maintenances = Mantenimiento::where('vehiculo_id', $vehicleId)->get();
        if(!$maintenances)
        {
            $response = response()->json(GetMaintenanceResource::collection($maintenances), 200);
        }
        return $response;
    }

    public function storeMaintenance(Request $request): JsonResponse
    {
        try {
            $maintenance = new Mantenimiento();
            $maintenance->vehiculo_id         = $request->vehicleId;
            $maintenance->titulo              = $request->titulo;
            $maintenance->descripcion         = $request->descripcion;
            $maintenance->url_foto            = $request->url_foto;
            $maintenance->fecha               = $request->fecha;
            $maintenance->nombre_mecanico     = $request->nombre_mecanico;
            $maintenance->precio              = $request->precio;
            $maintenance->save();
            return response()->json(['id' => $maintenance->id, 'status' => 'success'], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error en registro de mantenimiento: ' . $e->getMessage(), "status" => "invalid"], 500);
        }
    }

    public function updateMaintenance(Request $request, int $maintenanceId): JsonResponse
    {
        $response = response()->json(['message' => 'Error en actualización de mantenimiento', "status" => "invalid"], 500);
        $maintenance = Mantenimiento::where('id', $maintenanceId)->first();
        if ($maintenance instanceof Mantenimiento) {
            try {
                $maintenanceUpdated = Mantenimiento::where('id', $maintenanceId)->update([
                    'vehiculo_id'         => $request->vehiculo_id,
                    'titulo'              => $request->titulo,
                    'descripcion'         => $request->descripcion,
                    'url_foto'            => $request->url_foto,
                    'fecha'               => $request->fecha,
                    'nombre_mecanico'     => $request->nombre_mecanico,
                ]);

                if ($maintenanceUpdated) {
                    $response = response()->json(['id' => $maintenanceId, 'status' => 'success'], 201);
                }
            } catch (Exception $e) {
                $response = response()->json(['message' => 'Error en actualizar el mantenimiento: ' . $e->getMessage(), "status" => "invalid"], 500);
            }
        }
        return $response;
    }

    public function deleteMaintenance(int $maintenanceId): JsonResponse
    {
        $response = response()->json(['message' => 'Error al eliminar el mantenimiento', "status" => "invalid"], 500);
        try {
            $maintenanceDeleted = Mantenimiento::where('id', $maintenanceId)->delete();
            if($maintenanceDeleted){
                $response = response()->json(['status' => 'success'], 200);
            }
        } catch (Exception $e) {
            $response = response()->json(['message' => 'Error al eliminar el mantenimiento: '.$e->getMessage(), "status" => "invalid"], 500);
        }
        return $response;
    }
}
