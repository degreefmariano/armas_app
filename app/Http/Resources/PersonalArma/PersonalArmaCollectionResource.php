<?php

namespace App\Http\Resources\PersonalArma;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use App\Http\Resources\PersonalArma\PersonalArmaResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PersonalArmaCollectionResource extends ResourceCollection
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
            'asignacion-arma' => $this->collection->map(
                function ($data) {
                    return new PersonalArmaResource($data);
                }
            )
        ];
    }
}
