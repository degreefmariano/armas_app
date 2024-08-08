<?php

namespace App\Http\Resources\PersonalCambioUnidad;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonalCambioUnidadResource extends JsonResource
{
    public function toArray($request)
    {
        $exclusiones = [20, 30, 49, 80, 99];

        return [
            'arma'         => $this->nro_ficha,
            'personal'     => trim($this->nlegajo_ps).' - '.trim($this->nombre_ps),
            'ud_anterior'  => [
                                'cod_ud_ar' => $this->ud_ar, 
                                'nom_ud_ar' => trim($this->nom_ud_ar)
                              ],
            'ud_nueva'     => [
                                'cod_ud_ps' => $this->ud_ps, 
                                'nom_ud_ps' => in_array($this->ud_ps, $exclusiones) ? 'SIN UNIDAD' : trim($this->nom_ud_ps)
                              ],
            'fecha_cambio' => Carbon::parse($this->fecha_cambio)->format('d-m-Y'),
            'decreto'      => trim($this->decreto)
        ];
    }
}
