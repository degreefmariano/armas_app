<?php

namespace App\Http\Resources\Auditoria;

use Illuminate\Http\Resources\Json\JsonResource;

class HistorialLoginResource extends JsonResource
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
            
            'cod_usr'                => $this->cod_usr,              
            'fecha_hora_login'       => $this->fecha_hora_login,
            'fecha_hora_logout'      => $this->fecha_hora_logout,
            'ip'                     => $this->ip,
            'name'                   => $this->name,                  
            'email'                  => $this->email,
            
        ];
    }
}
