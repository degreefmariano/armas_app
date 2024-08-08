<?php

namespace App\Http\Resources\Personal;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Personal\UnidadResource;

class UnidadCollectionResource extends ResourceCollection
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
            'unidades' => $this->collection->map(
                function ($data) {
                    return new UnidadResource($data);
                }
            )
        ];
    }
}
