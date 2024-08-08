<?php

namespace App\Http\Resources\Devolucion;

use App\Models\Devolucion;
use App\Models\Subunidad;
use App\Models\Personal;
use App\Models\Unidad;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class DevolucionArmaPersonalResource extends JsonResource
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
            'id_devolucion'       => $this->id,
            'nro_nota'            => $this->nro_nota,
            'ud_recibe'           => trim($this->udRecibe->nom_ud),
            'tipo_devolucion'     => ($this->tipo == Devolucion::DEVOLUCION_PERSONAL) ? 'DE PERSONAL' : 'DE UD',
            'personal_devuelve'   => $this->personal->nlegajo_ps. ' - '.trim($this->personal->nombre_ps),
            'ud_arma_anterior'    => trim($this->UdAnterior->nom_ud),
            'subud_arma_anterior' => trim($this->subUdAnterior->nom_subud),            
            'fecha_devolucion'    => Carbon::parse($this->fecha_devolucion)->format('d-m-Y'),
            'obs'                 => $this->obs,
            'user_recibe'         => $this->usuario->name
        ];
    }
}
