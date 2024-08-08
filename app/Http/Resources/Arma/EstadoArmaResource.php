<?php

namespace App\Http\Resources\Arma;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class EstadoArmaResource extends JsonResource
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
            'estado'                   => $this->nom_estado,
            'fecha_movimiento'         => Carbon::parse($this->fecha_movimiento)->format('d-m-Y'),
            'obs'                      => $this->obs,
        ];
    }
}
