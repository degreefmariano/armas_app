<?php

namespace App\Http\Resources\Arma;

use App\Http\Resources\CuibsArma\CuibsArmaCollectionResource;
use App\Models\CalibreArma;
use App\Models\CambioSituacionArma;
use App\Models\CortaLargaArma;
use App\Models\CuibArma;
use App\Models\EstadoArma;
use App\Models\MarcaArma;
use App\Models\MedidaCalibreArma;
use App\Models\PersonalArma;
use App\Models\SituacionArma;
use App\Models\SubSituacionArma;
use App\Models\TipoArma;
use App\Models\UsoArma;
use App\Models\User;
use App\Repositories\PersonalRepository;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ArmaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'nro_ficha'                => trim($this->nro_ficha),
            'nro_arma'                 => trim($this->nro_arma),
            'cod_tipo_arma'            => TipoArma::tipoArmaId($this->cod_tipo_arma),
            'cod_marca'                => MarcaArma::marcaArmaId($this->cod_marca),
            'cod_calibre_principal'    => CalibreArma::calibreArmaId($this->cod_calibre_principal),
            'modelo'                   => $this->modelo,
            'medida_calibre_principal' => MedidaCalibreArma::medidaCalibreArmaId($this->medida_calibre_principal),
            'largo_canon_principal'    => $this->largo_canon_principal,
            'arma_corta_larga'         => CortaLargaArma::cortaLargaArmaId($this->arma_corta_larga),
            'clasificacion'            => UsoArma::usoArmaId($this->clasificacion),
            'situacion'                => SituacionArma::situacionArmaId($this->situacion),
            'estado'                   => EstadoArma::estadoArmaId($this->estado),
            'fecha_alta'               => Carbon::parse($this->fecha_alta)->format('d-m-Y'),
            'fecha_entrega'            => ($this->situacion == SituacionArma::SERVICIO and $this->arma_corta_larga == CortaLargaArma::CORTA) ? Carbon::parse(PersonalArma::fechaEntrega($this->nro_arma, $this->cod_tipo_arma, $this->cod_marca, $this->cod_calibre_principal))->format('d-m-Y') : "",   
            'funcionario'              => ($this->situacion == SituacionArma::SERVICIO and $this->arma_corta_larga == CortaLargaArma::CORTA) ? trim(PersonalRepository::getPersonalArma($this->nro_arma, $this->cod_tipo_arma, $this->cod_marca, $this->cod_calibre_principal)) : "",
            'ud_ar'                    => PersonalRepository::unidadId($this->ud_ar),
            'subud_ar'                 => PersonalRepository::subUnidadId($this->subud_ar),
            'obs'                      => $this->obs,
            'cuibs'                    => CuibArma::cuibsArmaId($this->nro_ficha),
            'subsituacion_id'          => ($this->sub_situacion) ? SubSituacionArma::subSituacionArmaId($this->sub_situacion) : null, 
            'subsituacion_descripcion' => ($this->sub_situacion) ? SubSituacionArma::subSituacionArmaDesc($this->sub_situacion) : "", 
            'trabajo_realizado'        => ($this->sub_situacion AND $this->sub_situacion == SubSituacionArma::SUBSITUACION_REPARACION) ? CambioSituacionArma::getTrabajoRealizado($this->nro_arma, $this->cod_tipo_arma, $this->cod_marca, $this->cod_calibre_principal, $this->situacion) : "",
            'sustraccion_extravio'     => ($this->situacion == SituacionArma::EXTRAVIADA or $this->situacion == SituacionArma::SUSTRAIDA) ? CambioSituacionArma::getSustraccionExtravioSecuestro($this->nro_arma, $this->cod_tipo_arma, $this->cod_marca, $this->cod_calibre_principal, $this->situacion) : "",
            'secuestro'                => ($this->situacion == SituacionArma::SEC_JUD) ? CambioSituacionArma::getSustraccionExtravioSecuestro($this->nro_arma, $this->cod_tipo_arma, $this->cod_marca, $this->cod_calibre_principal, $this->situacion) : "",
            'fuera_servicio'           => ($this->situacion == SituacionArma::FUERA_SERVICIO) ? CambioSituacionArma::getObs($this->nro_arma, $this->cod_tipo_arma, $this->cod_marca, $this->cod_calibre_principal, $this->situacion) : "",
            'baja'                     => ($this->situacion == SituacionArma::BAJA) ? CambioSituacionArma::getObs($this->nro_arma, $this->cod_tipo_arma, $this->cod_marca, $this->cod_calibre_principal, $this->situacion) : "",
            'reingreso'                => ($this->situacion == SituacionArma::REINGRESO) ? CambioSituacionArma::getObs($this->nro_arma, $this->cod_tipo_arma, $this->cod_marca, $this->cod_calibre_principal, $this->situacion) : "",
            'devolucion_ud_a_d4'       => ($this->situacion == SituacionArma::DEVOLUCION_UD_A_D4) ? CambioSituacionArma::getObs($this->nro_arma, $this->cod_tipo_arma, $this->cod_marca, $this->cod_calibre_principal, $this->situacion) : "",
        ];
    }
}
