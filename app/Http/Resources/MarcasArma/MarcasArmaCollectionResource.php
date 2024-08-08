<?php

namespace App\Http\Resources\MarcasArma;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use App\Http\Resources\MarcasArma\MarcasArmaResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MarcasArmaCollectionResource extends ResourceCollection
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
            'marcas-arma' => $this->collection->map(
                function ($data) {
                    return new MarcasArmaResource($data);
                }
            )
        ];
    }
}
