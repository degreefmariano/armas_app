<?php

namespace App\Http\Resources\Arma;

use Illuminate\Http\Resources\Json\JsonResource;

class ArmaDepositoResource extends JsonResource
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
            'nro_ficha'             => $this->nro_ficha,
            'nro_arma'              => $this->nro_arma,
            'cod_tipo_arma'         => trim($this->tipo?->descripcion),
            'cod_marca'             => trim($this->marca?->descripcion),
            'cod_calibre_principal' => trim($this->calibre?->descripcion),
            'modelo'                => trim($this->modelo),
            'corta_larga'           => $this->cortaLarga?->descripcion,
            'estado'                => trim($this->estadoArma?->nom_estado)
        ];
    }
}
