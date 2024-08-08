<?php

namespace App\Http\Resources\Jobs;

use Illuminate\Http\Resources\Json\JsonResource;

class JobsListResource extends JsonResource
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
            'id'              => $this->id,
            'proceso_arma'    => ($this->tipo == 1) ? 'CORTA' : 'LARGA',
            'usuario_proceso' => trim($this->usuario->name),
            'fecha_proceso'   => $this->queue,
            'estado'          => $this->status,
        ];
    }
}
