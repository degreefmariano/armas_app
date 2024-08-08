<?php

namespace App\Http\Resources\EstadosArma;

use Illuminate\Http\Resources\Json\JsonResource;

class EstadosArmaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'cod_estado' => $this->cod_estado,
            'nom_estado' => $this->nom_estado,
        ];
    }
}
