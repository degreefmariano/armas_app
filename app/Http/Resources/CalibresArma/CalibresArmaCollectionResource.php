<?php

namespace App\Http\Resources\CalibresArma;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\CalibresArma\CalibresArmaResource;

class CalibresArmaCollectionResource extends ResourceCollection
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
            'calibres-arma' => $this->collection->map(
                function ($data) {
                    return new CalibresArmaResource($data);
                }
            )
        ];
    }
}
