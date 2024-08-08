<?php

namespace App\Http\Resources\CuibsArma;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use App\Http\Resources\CuibsArma\CuibsArmaResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CuibsArmaCollectionResource extends ResourceCollection
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
            'cuibs' => $this->collection->map(
                function ($data) {
                    return new CuibsArmaResource($data);
                }
            )
        ];
    }
}
