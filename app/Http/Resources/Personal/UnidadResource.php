<?php

namespace App\Http\Resources\Personal;

use Illuminate\Http\Resources\Json\JsonResource;

class UnidadResource extends JsonResource
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
            'cod_ud' => $this->cod_ud,
            'nom_ud' => trim($this->nom_ud)
        ];
    }
}
