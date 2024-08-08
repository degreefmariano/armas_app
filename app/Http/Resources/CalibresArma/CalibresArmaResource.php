<?php

namespace App\Http\Resources\CalibresArma;

use Illuminate\Http\Resources\Json\JsonResource;

class CalibresArmaResource extends JsonResource
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
            'descripcion' => trim($this->descripcion),
        ];
    }
}
