<?php

namespace App\Http\Resources\Auditoria;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class HistorialArmaResource extends JsonResource
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

            'nro_ficha'           => $this->nro_ficha,
            'nro_arma'            => $this->nro_arma,
            'tipo'                => trim($this->tipo?->descripcion),
            'marca'               => trim($this->marca?->descripcion),
            'calibre'             => trim($this->calibre?->descripcion),
            'clasificacion'       => $this->cortaLarga?->descripcion,
            'situacion'           => $this->situacionArma?->nom_situacion,
            'sub_situacion'       => $this->subSituacionArma?->descripcion,
            'ud_ar'               => trim($this->unidad?->nom_ud),
            'estado'              => $this->estadoArma?->nom_estado,
            'fecha_auditoria'     => Carbon::parse($this->fecha)->format('Y-m-d').' / '.Carbon::parse($this->hora)->format('H:i:s'),
            'usuario_modifico'    => $this->usuario?->name,
            'usr_ud'              => trim($this->usr_ud?->unidad->nom_ud), 
            'usr_subud'           => trim($this->usr_subud?->subUnidad->nom_subud), 
        ];
    }
}
