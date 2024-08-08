<?php

namespace App\Http\Resources\Departamento;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DepartamentoCollectionResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'departamentos' => $this->collection->map(
                function ($data) {
                    return new DepartamentoResource($data);
                }
            )
        ];
    }
}
