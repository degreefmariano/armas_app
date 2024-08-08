<?php

namespace App\Http\Resources\EstadosArma;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\EstadosArma\EstadosArmaResource;

class EstadosArmaCollectionResource extends ResourceCollection
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
            'estados-arma' => $this->collection->map(
                function ($data) {
                    return new EstadosArmaResource($data);
                }
            )
        ];
    }
}
