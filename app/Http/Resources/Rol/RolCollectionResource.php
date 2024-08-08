<?php

namespace App\Http\Resources\Rol;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RolCollectionResource extends ResourceCollection
{

    public function toArray($request)
    {
        return [
            'resultados' => $this->collection->map(
                function ($data) {
                    return new RolResource($data);
                }
            )
        ];
    }
}
