<?php

namespace App\Http\Resources\EstadosUsr;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EstadosUsrCollectionResource extends ResourceCollection
{

    public function toArray($request)
    {
        return [
            'resultados' => $this->collection->map(
                function ($data) {
                    return new EstadosUsrResource($data);
                }
            )
        ];
    }
}
