<?php

namespace App\Http\Resources\CuibsArma;

use Illuminate\Http\Resources\Json\JsonResource;

class CuibsArmaResource extends JsonResource
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
            'nro_ficha'   => $this->nro_ficha,
            'sobre1_cuib' => $this->sobre1_cuib,
            'sobre2_cuib' => $this->sobre2_cuib,
            'caja_cuib'   => $this->caja_cuib,
            'fecha_cuib'  => $this->fecha_cuib,
            'id_usr'      => $this->id_usr,
        ];
    }
}
