<?php

namespace App\Http\Resources\Localidad;

use App\Models\Rol;
use Illuminate\Http\Resources\Json\JsonResource;

class LocalidadResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'     => $this->id_localidad,
            'nombre' => $this->nom_localidad
        ];
    }
}
