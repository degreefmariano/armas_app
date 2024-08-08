<?php

namespace App\Http\Resources\User;

use App\Models\Localidad;
use App\Models\Rol;
use App\Models\Subunidad;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request) 
    {
        $email_name            = explode('@', $this->email);
        return [
            'id'               => $this->id,
            'legajo'           => $this->legajo,
            'email'            => $this->email,
            'documento'        => $this->documento,
            'cuil'             => $this->cuil,
            'name'             => $this->name,
            'email_name'       => $email_name[0],
            'unidad_cod'       => $this->cod_ud,
            'unidad_nom'       => trim($this->unidad?->nom_ud),
            'subunidad_cod'    => $this->cod_subud,
            'subunidad_nom'    => trim($this->subUnidad?->nom_subud),
            'fecha_alta'       => $this->fecha_alta,
            'rol_id'           => $this->Rol?->id,
            'rol_name'         => $this->Rol?->nombre,
            'estado_usr_id'    => $this->estado_usr,
            'estado_usr_name'  => ($this->estado_usr == 1) ? 'ACTIVO':'INACTIVO',
            'obs_usr'          => $this->obs_usr,
            'vencimiento'      => $this->vencimiento,
            'localidad_id'     => $this->localidad?->id_localidad,
            'localidad_name'   => $this->localidad?->nom_localidad,
            'departamento_id'  => $this->localidad?->departamento?->id_departamento,
            'departamento_name'=> $this->localidad?->departamento?->nom_departamento
        ];
    }
}
