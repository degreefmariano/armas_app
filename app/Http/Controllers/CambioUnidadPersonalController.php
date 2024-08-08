<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\CambioUnidadPersonalInterface;
use App\Http\Requests\PersonalCambioUnidad\PersonalCambioUnidadRequest;

class CambioUnidadPersonalController extends Controller
{
    protected $repository;

    public function __construct(CambioUnidadPersonalInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getPersonalCambioUnidad(Request $request)
    {
        try {
            $personalCambioUnidad = $this->repository->getPersonalCambioUnidad($request);
            return api()->ok('Listado de personal con cambio de unidad', $personalCambioUnidad);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function updatePersonalCambioUnidad(int $ficha, PersonalCambioUnidadRequest $request)
    {
        try {
            $personalCambioUnidad = $this->repository->updatePersonalCambioUnidad($ficha, $request);
            return api()->ok('Cambio de unidad exitoso', $personalCambioUnidad);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
       
    }
}
