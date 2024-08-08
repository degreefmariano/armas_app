<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\MarcaArma;
use Illuminate\Http\Request;
use App\Repositories\Contracts\MarcaArmaInterface;
use App\Http\Resources\MarcasArma\MarcasArmaCollectionResource;
use App\Http\Resources\MarcasArma\MarcasArmaResource;

final class MarcaArmaRepository implements MarcaArmaInterface
{
    protected MarcaArma $marcaArmaModel;

    public function __construct(MarcaArma $marcaArmaModel)
    {
        $this->marcaArmaModel = $marcaArmaModel;
    }

    public function getMarcasArma()
    {
        return new MarcasArmaCollectionResource($this->marcaArmaModel->getMarcasArma());
    }

    public function createMarcaArma(Request $request)
    {
        return new MarcasArmaResource($this->marcaArmaModel->createMarcaArma($request));
        
    }

    public function updateMarcaArma($marcaArmaId, Request $request)
    { 
        return new MarcasArmaResource($this->marcaArmaModel->updateMarcaArma($marcaArmaId, $request));
        
    }
}
