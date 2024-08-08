<?php

namespace App\Http\Resources\Consultas;

use App\Models\Personal;
use App\Models\SituacionArma;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultaArmaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'nro_ficha'                => $this->nro_ficha,
            'fecha_alta'               => $this->fecha_alta,
            'modelo'                   => trim($this->modelo),
            'nro_arma'                 => $this->nro_arma,
            'cod_tipo_arma'            => $this->cod_tipo_arma,
            'nom_tipo_arma'            => trim($this->nom_tipo_arma),
            'cod_marca'                => $this->cod_marca,
            'nom_marca_arma'           => trim($this->nom_marca_arma),
            'cod_calibre_principal'    => $this->cod_calibre_principal,
            'nom_cal_principal'        => trim($this->nom_cal_principal),
            'arma_corta_larga'         => $this->arma_corta_larga,
            'corta_larga'              => $this->corta_larga,
            'medida_calibre_principal' => $this->medida_calibre_principal,
            'nom_medida_cal_ppal'      => $this->nom_medida_cal_ppal,
            'largo_canon_principal'    => $this->largo_canon_principal,
            'clasificacion'            => $this->clasificacion,
            'uso'                      => $this->uso,
            'situacion'                => $this->situacion,
            'asignada'                 => ($this->situacion == SituacionArma::SERVICIO) ? Personal::getPersonalArmaAsignada($this->personal_legajo) : "",
            'subud_asignada'           => trim(($this->situacion == SituacionArma::SERVICIO) ? trim($this?->subUnidad?->nom_subud) : ""),
            'subsituacion'             => $this->subsituacion,
            'nom_situacion'            => $this->nom_situacion,
            'descripcion'              => $this->descripcion,
            'obs'                      => trim($this->obs),
            'ud_ar'                    => trim($this?->unidad?->nom_ud),
            'subud_ar'                 => trim($this?->subUnidad?->nom_subud),
            'estado'                   => $this->estado,
            'nom_estado'               => $this->nom_estado,
        ];
    }
}
