<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;

class GetUserResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'usuario_id'                => $this->id,
            'nombre'                    => $this->nombre,
            'apellido'                  => $this->apellido,
            'telefono'            => $this->telefono,
            'identificacion'      => $this->identificacion,
            'correo'            => $this->email,
            'contrasenia'       => $this->password,
        ];
    }
}
