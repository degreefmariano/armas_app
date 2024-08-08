<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\VistaArma;
use Illuminate\Http\Request;
use App\Repositories\Contracts\ConsultaArmaInterface;
use App\Http\Resources\Consultas\ConsultaArmaCollectionResource;
use App\Http\Resources\Consultas\ConsultaArmaClaveCollectionResource;

final class ConsultaArmaRepository implements ConsultaArmaInterface
{
    protected VistaArma $VistaArmaModel;

    public function __construct(VistaArma $VistaArmaModel)
    {
        $this->VistaArmaModel = $VistaArmaModel;
    }

    public function getArmasFiltros(Request $request)
    {
        return new ConsultaArmaCollectionResource($this->VistaArmaModel->getArmasFiltros(
            $request,
            $request['page'],    
            $request['offset']));
    }

    public function getArmaClave(Request $request)
    {
        return new ConsultaArmaClaveCollectionResource($this->VistaArmaModel->getArmaClave(
            $request,
            $request['page'],    
            $request['offset']));
    }

    public function getArmaClaveAsignar(Request $request)
    {
        return new ConsultaArmaClaveCollectionResource($this->VistaArmaModel->getArmaClaveAsignar(
            $request,
            $request['page'],    
            $request['offset']));
    }
    
}
