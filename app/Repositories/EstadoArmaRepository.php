<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\EstadoArma;
use Illuminate\Http\Request;
use App\Repositories\Contracts\EstadoArmaInterface;
use App\Http\Resources\EstadosArma\EstadosArmaCollectionResource;
use App\Http\Resources\EstadosArma\EstadosArmaResource;

final class EstadoArmaRepository implements EstadoArmaInterface
{
    protected EstadoArma $estadoArmaModel;

    public function __construct(EstadoArma $estadoArmaModel)
    {
        $this->estadoArmaModel = $estadoArmaModel;
    }

    public function getEstadosArma()
    {
        return new EstadosArmaCollectionResource($this->estadoArmaModel->getEstadosArma());
    }

    public function createEstadoArma(Request $request)
    { 
        return new EstadosArmaResource($this->estadoArmaModel->createEstadoArma($request));
        
    } 

    public function updateEstadoArma($estadoArmaId, Request $request)
    { 
        return new EstadosArmaResource($this->estadoArmaModel->updateEstadoArma($estadoArmaId, $request));
        
    }
}
