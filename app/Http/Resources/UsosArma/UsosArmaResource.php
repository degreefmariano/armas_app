<?php

namespace App\Http\Resources\UsosArma;

use Illuminate\Http\Resources\Json\JsonResource;

class UsosArmaResource extends JsonResource
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
