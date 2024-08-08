<?php

namespace App\Http\Resources\Personal;

use App\Models\Historico;
use App\Models\PersonalArma;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonalHistoricoArmaResource extends JsonResource
{
    /**
     * Transform the resourUnidadCollectionResourcece into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'nlegajo_ps'     => $this->nlegajo_ps,
            'nombre_ps'      => trim($this->nombre_ps),
            'desc_esc'       => trim($this->desc_esc),
            'nom_sestados'   => trim($this->nom_sestados),
            'ud_ps'          => $this->ud_ps,
            'nom_ud'         => trim($this->nom_ud),
            'nom_subud'      => trim($this->nom_subud),
            'ndoc_ps'        => $this->ndoc_ps,
            'nom_gr'         => trim($this->nom_gr),
            'fec_alta_ps'    => $this->fec_alta_ps,
            'fec_baja_ps'    => $this->fec_baja_ps == "0" ? null : $this->fec_baja_ps,
            'fec_nac_ps'     => $this->fec_nac_ps,
            'sexo_ps'        => $this->sexo_ps, 
            'srevista_ps'    => ($this->srevista_ps == 1) ? 'ACTIVO' : 'INACTIVO',
            'arma_actual'    => PersonalArma::getArmaActual($this->nlegajo_ps),
            'arma_historico' => Historico::getArmaHistorico($this->nlegajo_ps)
        ];
    }
}
