<?php

namespace App\Http\Resources\Departamento;

use App\Models\Rol;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartamentoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'     => $this->id_departamento,
            'nombre' => $this->nom_departamento
        ];
    }
}
