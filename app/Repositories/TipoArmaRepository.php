<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\TipoArma;
use Illuminate\Http\Request;
use App\Http\Resources\TiposArma\TiposArmaCollectionResource;
use App\Http\Resources\TiposArma\TiposArmaResource;
use App\Repositories\Contracts\TipoArmaInterface;

final class TipoArmaRepository implements TipoArmaInterface
{
    protected TipoArma $tipoArmaModel;

    public function __construct(TipoArma $tipoArmaModel)
    {
        $this->tipoArmaModel = $tipoArmaModel;
    }

    public function getTiposArma()
    {
        return new TiposArmaCollectionResource($this->tipoArmaModel->getTiposArma());
    }

    public function createTipoArma(Request $request)
    {
        return new TiposArmaResource($this->tipoArmaModel->createTipoArma($request));
    }

    public function updateTipoArma($tipoArmaId, Request $request)
    {
        return new TiposArmaResource($this->tipoArmaModel->updateTipoArma($tipoArmaId, $request));
        
    }

    
}
