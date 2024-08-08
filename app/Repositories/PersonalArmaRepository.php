<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Resources\Arma\ArmaResource;
use App\Models\PersonalArma;
use Illuminate\Http\Request;
use App\Repositories\Contracts\PersonalArmaInterface;

final class PersonalArmaRepository implements PersonalArmaInterface
{
    protected PersonalArma $asignarArmaModel;

    public function __construct(PersonalArma $asignarArmaModel)
    {
        $this->asignarArmaModel = $asignarArmaModel;
    }

    public function asignarArmaPersonal(Request $request)
    {
        return new ArmaResource($this->asignarArmaModel->asignarArmaPersonal($request));
    }

    public function devolverArmaPersonal(Request $request)
    {
        return new ArmaResource($this->asignarArmaModel->devolverArmaPersonal($request));
    }

    public function devolucionEspecialArmaPersonal(Request $request)
    {
        return new ArmaResource($this->asignarArmaModel->devolucionEspecialArmaPersonal($request));
    }

}
