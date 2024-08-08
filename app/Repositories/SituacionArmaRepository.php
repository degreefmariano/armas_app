<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\SituacionArma;
use Illuminate\Http\Request;
use App\Repositories\Contracts\SituacionArmaInterface;
use App\Http\Resources\SituacionesArma\SituacionesArmaCollectionResource;
use App\Http\Resources\SituacionesArma\SituacionesArmaResource;

final class SituacionArmaRepository implements SituacionArmaInterface
{
    protected SituacionArma $situacionArmaModel;

    public function __construct(SituacionArma $situacionArmaModel)
    {
        $this->situacionArmaModel = $situacionArmaModel;
    }

    public function getSituacionesArma()
    {
        return new SituacionesArmaCollectionResource($this->situacionArmaModel->getSituacionesArma());
    }

    public function createSituacionArma(Request $request)
    { 
        return new SituacionesArmaResource($this->situacionArmaModel->createSituacionArma($request));
        
    } 

    public function updateSituacionArma($situacionArmaId, Request $request)
    { 
        return new SituacionesArmaResource($this->situacionArmaModel->updateSituacionArma($situacionArmaId, $request));
        
    }
}
