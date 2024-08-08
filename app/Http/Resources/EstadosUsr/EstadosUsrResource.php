<?php

namespace App\Http\Resources\EstadosUsr;

use Illuminate\Http\Resources\Json\JsonResource;

class EstadosUsrResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'     => $this->id,
            'nombre' => trim($this->nombre),
        ];
    }
}
