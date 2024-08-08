<?php

namespace App\Http\Resources\CortaLargaArma;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\CortaLargaArma\CortaLargaArmaResource;

class CortaLargaArmaCollectionResource extends ResourceCollection
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
            'corta-larga-arma' => $this->collection->map(
                function ($data) {
                    return new CortaLargaArmaResource($data);
                }
            )
        ];
    }
}
