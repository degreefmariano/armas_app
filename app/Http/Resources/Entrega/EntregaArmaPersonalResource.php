<?php

namespace App\Http\Resources\Entrega;

use App\Models\Entrega;
use App\Models\Subunidad;
use App\Models\Personal;
use App\Models\Unidad;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class EntregaArmaPersonalResource extends JsonResource
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
            'id_entrega'    => $this->id,
            'nro_nota'      => $this->nro_nota,
            'tipo_entrega'  => ($this->tipo == Entrega::ENTREGA_PERSONAL) ? 'A PERSONAL' : 'A UD',
            'personal'      => $this->legajo_personal. ' - '.trim($this->personal_nombre),
            'ud_recibe'     => trim($this->udRecibe_nombre),
            'subud_recibe'  => trim($this->subUdRecibe_nombre),
            'fecha_entrega' => Carbon::parse($this->fecha_entrega)->format('d-m-Y'),
            'obs'           => $this->obs,
            'user_entrega'  => $this->usuario_nombre
        ];
    }
}
