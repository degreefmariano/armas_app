<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Arma;
use Illuminate\Http\Request;
use App\Models\CambioEstadoArma;
use App\Models\CambioSituacionArma;
use App\Http\Resources\Arma\ArmaResource;
use App\Repositories\Contracts\ArmaInterface;
use App\Http\Resources\Arma\HistorialArmaCollectionResource;
use App\Http\Resources\Arma\ArmaDepositoCollectionResource;

final class ArmaRepository implements ArmaInterface
{
    protected Arma $armaModel;

    public function __construct(Arma $armaModel)
    {
        $this->armaModel = $armaModel;
    }

    public function getArma(Request $request)
    {
        return new ArmaResource($this->armaModel->getArma($request));
    }

    public function createArma(Request $request)
    {
        return new ArmaResource($this->armaModel->createArma($request));
    }

    public function updateArma($ficha, Request $request)
    {
        return new ArmaResource($this->armaModel->updateArma($ficha, $request));
    }

    public function updateEstadoArma($ficha, Request $request)
    {
        return new ArmaResource($this->armaModel->updateEstadoArma($ficha, $request));
    }

    public function updateSituacionArma($ficha, Request $request)
    {
        return new ArmaResource($this->armaModel->updateSituacionArma($ficha, $request));
    }

    public function getHistorialArma(Request $request)
    {
        return new HistorialArmaCollectionResource([
            CambioSituacionArma::getSituacionHistorialArma($request),
            CambioEstadoArma::getEstadoHistorialArma($request)
        ]);
    }

    public function getArmasDepositoPorUd(Request $request)
    {
        return new ArmaDepositoCollectionResource($this->armaModel->getArmasDepositoPorUd($request, $request['page'],    
        $request['offset']));
    }

    public function getArmasUdDevuelve(Request $request)
    {
        return new ArmaDepositoCollectionResource($this->armaModel->getArmasUdDevuelve($request, $request['page'],    
        $request['offset']));
    }

    public function getArmasDependenciaAUdDevuelve(Request $request)
    {
        return new ArmaDepositoCollectionResource($this->armaModel->getArmasDependenciaAUdDevuelve($request, $request['page'],    
        $request['offset']));
    }
}
