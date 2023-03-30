<?php

namespace App\Http\Resources\Maintenance;

use Illuminate\Http\Resources\Json\JsonResource;

class GetMaintenanceResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'maintenance_id'    => $this->id,
            'vehiculo_id'       => $this->vehiculo_id,
            'titulo'            => $this->titulo,
            'descripcion'       => $this->descripcion,
            'url_foto'          => $this->url_foto,
            'fecha'             => $this->fecha,
            'nombre_mecanico'   => $this->nombre_mecanico,
            // 'precio'         => number_format(floatval($this->precio), 2,',','.'),
            'precio'            => floatval($this->precio),
        ];
    }
}
