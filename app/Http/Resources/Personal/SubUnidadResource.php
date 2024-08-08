<?php

namespace App\Http\Resources\Personal;

use Illuminate\Http\Resources\Json\JsonResource;

class SubUnidadResource extends JsonResource
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
            'cod_subud' => $this->cod_subud,
            'nom_subud' => trim($this->nom_subud)
        ];
    }
}
