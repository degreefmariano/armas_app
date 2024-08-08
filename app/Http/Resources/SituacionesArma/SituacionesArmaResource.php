<?php

namespace App\Http\Resources\SituacionesArma;

use Illuminate\Http\Resources\Json\JsonResource;

class SituacionesArmaResource extends JsonResource
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
            'cod_situacion' => $this->cod_situacion,
            'nom_situacion' => $this->nom_situacion,
        ];
    }
}
