<?php

namespace App\Http\Resources\MedidaCalibreArma;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\MedidaCalibreArma\MedidaCalibreArmaResource;

class MedidaCalibreArmaCollectionResource extends ResourceCollection
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
            'medida-calibre-arma' => $this->collection->map(
                function ($data) {
                    return new MedidaCalibreArmaResource($data);
                }
            )
        ];
    }
}
