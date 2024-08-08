<?php

namespace App\Http\Resources\UsosArma;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\UsosArma\UsosArmaResource;

class UsosArmaCollectionResource extends ResourceCollection
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
            'usos-arma' => $this->collection->map(
                function ($data) {
                    return new UsosArmaResource($data);
                }
            )
        ];
    }
}
