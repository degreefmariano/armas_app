<?php

namespace App\Http\Resources\SubSituacionArma;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\SubSituacionArma\SubSituacionArmaResource;

class SubSituacionArmaCollectionResource extends ResourceCollection
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
            'subsituaciones-arma' => $this->collection->map(
                function ($data) {
                    return new SubSituacionArmaResource($data);
                }
            )
        ];
    }
}
