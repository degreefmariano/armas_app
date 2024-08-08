<?php

namespace App\Http\Resources\Personal;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonalNombreResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'nlegajo_ps'   => $this->nlegajo_ps,
            'nombre_ps'    => trim($this->nombre_ps),
            'nom_sestados' => trim($this->nom_sestados),
            'desc_esc'     => trim($this->desc_esc),
            'nom_ud'       => trim($this->nom_ud),
            'nom_subud'    => trim($this->nom_subud),
            'srevista_ps'  => $this->srevista_ps == 1 ? 'ACTIVO' : 'INACTIVO'
        ];
    }
}
