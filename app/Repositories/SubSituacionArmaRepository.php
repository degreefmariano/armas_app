<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\SubSituacionArma;
use Illuminate\Http\Request;
use App\Repositories\Contracts\SubSituacionArmaInterface;
use App\Http\Resources\SubSituacionArma\SubSituacionArmaCollectionResource;

final class SubSituacionArmaRepository implements SubSituacionArmaInterface
{
    protected SubSituacionArma $subsituacionArmaModel;

    public function __construct(SubSituacionArma $subsituacionArmaModel)
    {
        $this->subsituacionArmaModel = $subsituacionArmaModel;
    }

    public function getSubSituacionesArma(Request $request)
    {
        return new SubSituacionArmaCollectionResource($this->subsituacionArmaModel->getSubSituacionesArma($request));
    }

}
