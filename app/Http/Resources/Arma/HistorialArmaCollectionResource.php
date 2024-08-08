<?php

namespace App\Http\Resources\Arma;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class HistorialArmaCollectionResource extends ResourceCollection
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
            'situaciones' => $this->collection[0]->map(
                function ($data) {
                    return new SituacionArmaResource($data);
                }
            ),
            'estados' => $this->collection[1]->map(
                function ($data) {
                    return new EstadoArmaResource($data);
                }
            )
        ];
    }
}
