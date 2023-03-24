<?php

namespace App\Http\Resources\Vehicle;

use Illuminate\Http\Resources\Json\JsonResource;

class GetVehicleResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'user_id' => $this->user_id,
            'clase_vehiculo' => $this->clasesVehiculo->tipo,
            'combustible' => $this->combustibles->tipo,
            'placa' => $this->placa,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'color' => $this->color,
            'cilindraje' => $this->cilindraje,
            'fecha_inicio_SOAT' => $this->fecha_inicio_SOAT,
            'fecha_fin_SOAT' => $this->fecha_fin_SOAT,
            'fecha_inicio_tecno' => $this->fecha_inicio_tecno,
            'fecha_fin_tecno' => $this->fecha_fin_tecno,
        ];
    }
}
