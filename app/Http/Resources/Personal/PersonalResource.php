<?php

namespace App\Http\Resources\Personal;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonalResource extends JsonResource
{
    public function toArray($request)
    {
        $latestId = User::latest('id')->first()->id + 1;
        $usuario = 'USUARIO' . $latestId;

        return [
            'nlegajo_ps'   => $this->nlegajo_ps,
            'nombre_ps'    => trim($this->nombre_ps),
            'desc_esc'     => trim($this->desc_esc),
            'nom_sestados' => trim($this->nom_sestados),
            'ud_ps'        => $this->ud_ps,
            'nom_ud'       => trim($this->nom_ud),
            'subud_ps'     => trim($this->subud_ps),
            'nom_subud'    => trim($this->nom_subud),
            'ndoc_ps'      => $this->ndoc_ps,
            'cuil_ps'      => $this->cuil_ps,
            'nom_gr'       => trim($this->nom_gr),
            'fec_alta_ps'  => $this->fec_alta_ps,
            'fec_baja_ps'  => $this->fec_baja_ps == "0" ? null : $this->fec_baja_ps,
            'fec_nac_ps'   => $this->fec_nac_ps,
            'sexo_ps'      => $this->sexo_ps, 
            'srevista_ps'  => ($this->srevista_ps == 1) ? 'ACTIVO' : 'INACTIVO',
            'usuario'      => $usuario
        ];
    }
}
