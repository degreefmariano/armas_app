<?php

namespace App\Http\Resources\SituacionesArma;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\SituacionesArma\SituacionesArmaResource;

class SituacionesArmaCollectionResource extends ResourceCollection
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
            'situaciones-arma' => $this->collection->map(
                function ($data) {
                    return new SituacionesArmaResource($data);
                }
            )
        ];
    }
}
