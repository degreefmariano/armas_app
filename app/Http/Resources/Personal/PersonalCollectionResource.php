<?php

namespace App\Http\Resources\Personal;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Personal\PersonalNombreResource;

class PersonalCollectionResource extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'resultados' => $this->collection->map(
                function ($data) {
                    return new PersonalNombreResource($data);
                }
            ),
            'pagination' => [
                'total'         => $this->total(),
                'count'         => $this->count(),
                'per_page'      => $this->perPage(),
                'current_page'  => $this->currentPage(),
                'total_pages'   => $this->lastPage(),
            ],
        ];
    }
}
