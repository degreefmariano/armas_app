<?php

namespace App\Http\Resources\Arma;

use App\Models\CambioSituacionArma;
use App\Models\SituacionArma;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SituacionArmaResource extends JsonResource
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
            'situacion'        => $this->nom_situacion,
            'fecha_movimiento' => Carbon::parse($this->fecha_movimiento)->format('d-m-Y'),
            'obs'              => trim($this->obs)
        ];
    }
}