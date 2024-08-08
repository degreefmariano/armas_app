<?php

namespace App\Http\Resources\Arma;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use App\Http\Resources\Arma\ArmaDepositoResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArmaDepositoCollectionResource extends ResourceCollection
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
            'resultados' => $this->collection->map(
                function ($data) {
                    return new ArmaDepositoResource($data);
                }
            ),
            'pagination' => [
                'total'        => $this->total(),
                'count'        => $this->count(),
                'per_page'     => $this->perPage(),
                'current_page' => $this->currentPage(),
                'total_pages'  => $this->lastPage(),
            ],
        ];
    }
}
