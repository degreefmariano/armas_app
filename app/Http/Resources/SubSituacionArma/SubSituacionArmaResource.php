<?php

namespace App\Http\Resources\SubSituacionArma;

use Illuminate\Http\Resources\Json\JsonResource;

class SubSituacionArmaResource extends JsonResource
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
            'id'          => $this->id,
            'descripcion' => $this->descripcion,
        ];
    }
}
