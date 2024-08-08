<?php

namespace App\Http\Resources\Rol;

use App\Models\Localidad;
use App\Models\Rol;
use Illuminate\Http\Resources\Json\JsonResource;

class RolResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'     => $this->id,
            'nombre' => trim($this->nombre),
        ];
    }
}
