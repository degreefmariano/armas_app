<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Resources\Arma\ArmaCollectionResource;
use App\Models\Entrega;
use Illuminate\Http\Request;
use App\Repositories\Contracts\EntregaArmaInterface;
use App\Http\Resources\Entrega\EntregaArmaPersonalCollectionResource;

final class EntregaArmaRepository implements EntregaArmaInterface
{
    protected Entrega $entregaArmaModel;

    public function __construct(Entrega $entregaArmaModel)
    {
        $this->entregaArmaModel = $entregaArmaModel;
    }

    public function getEntregaArmaTipo(Request $request)
    {
        return new EntregaArmaPersonalCollectionResource($this->entregaArmaModel->getEntregaArmaTipo(
            $request,
            $request['page'],
            $request['offset']
        ));
    }

    public function asignarArmaMasiva(Request $request)
    {
        return new ArmaCollectionResource($this->entregaArmaModel->asignarArmaMasiva($request));
    }

    public function asignarArmaMasivaLargas(Request $request)
    {
        return $this->entregaArmaModel->asignarArmaMasivaLargas($request);
    }
}
