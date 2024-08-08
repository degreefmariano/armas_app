<?php

namespace App\Http\Resources\TiposArma;

use JsonSerializable;
use Illuminate\Http\Request;
use App\Http\Resources\TiposArma\TiposArmaResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TiposArmaCollectionResource extends ResourceCollection
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
            'tipos-arma' => $this->collection->map(
                function ($data) {
                    return new TiposArmaResource($data);
                }
            )
        ];
    }
}
