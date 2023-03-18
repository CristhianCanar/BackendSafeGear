<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;
    protected $table = "vehiculos";

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function combustibles()
    {
        return $this->belongsTo(Combustible::class, 'combustible_id');
    }

    public function clasesVehiculo()
    {
        return $this->belongsTo(ClaseVehiculo::class, 'clase_vehiculo_id');
    }
}
