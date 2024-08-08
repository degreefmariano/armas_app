<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Resources\Arma\ArmaCollectionResource;
use App\Http\Resources\Devolucion\DevolucionArmaPersonalCollectionResource;
use App\Models\Devolucion;
use Illuminate\Http\Request;
use App\Repositories\Contracts\DevolucionArmaInterface;

final class DevolucionArmaRepository implements DevolucionArmaInterface
{
    protected Devolucion $devolucionArmaModel;

    public function __construct(Devolucion $devolucionArmaModel)
    {
        $this->devolucionArmaModel = $devolucionArmaModel;
    }

    public function devolverArmasMasiva(Request $request)
    {
        return new ArmaCollectionResource($this->devolucionArmaModel->devolverArmasMasiva($request));
    }

    public function getDevolucionArmaTipo(Request $request)
    {
        return new DevolucionArmaPersonalCollectionResource($this->devolucionArmaModel->getDevolucionArmaTipo(
            $request,
            $request['page'],
            $request['offset']
        ));
    }
}
