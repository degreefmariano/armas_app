<?php

namespace App\Http\Resources\Personal;

use App\Models\Arma;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonalDevolucionArmaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'nlegajo_ps' => $this->personal->nlegajo_ps,
            'nombre_ps'  => trim($this->personal->nombre_ps),
            'documento'  => $this->personal->ndoc_ps,
            'jerarquia'  => trim($this->personal->nom_gr),
            'srevista'   => ($this->personal->srevista_ps == 1) ? 'ACTIVO' : 'INACTIVO',
            'estado'     => mb_ereg_replace('^\s+|\s+$', '', $this->personal->nom_sestados),
            'unidad'     => trim($this->personal->nom_ud),
            'subunidad'  => trim($this->personal->nom_subud),
            'cargadores' => $this->cantidad_cargador,
            'municiones' => $this->cantidad_municion,
            'arma'       => Arma::getArmaAsignada($this->nro_arma, $this->cod_tipo_arma, $this->cod_marca, $this->cod_calibre_principal)
        ];
    }
}
