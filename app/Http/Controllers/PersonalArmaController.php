<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\PersonalArmaInterface;
use App\Http\Requests\Entrega\EntregaPersonalArmaRequest;
use App\Http\Requests\Devolucion\DevuelvePersonalArmaRequest;

class PersonalArmaController extends Controller
{
    protected $repository;

    public function __construct(PersonalArmaInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function asignarArmaPersonal(EntregaPersonalArmaRequest $request)
    {
        try {
            $asignarPersonalArma = $this->repository->asignarArmaPersonal($request);
            return api()->ok('Asignación exitosa', $asignarPersonalArma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());;
        }
    }

    public function devolverArmaPersonal(DevuelvePersonalArmaRequest $request)
    {
        try {
            $devolverPersonalArma = $this->repository->devolverArmaPersonal($request);
            return api()->ok('Devolución exitosa', $devolverPersonalArma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());;
        }
    }

    public function devolucionEspecialArmaPersonal(DevuelvePersonalArmaRequest $request)
    {
        try {
            $devolucionEspecialArmaPersonal = $this->repository->devolucionEspecialArmaPersonal($request);
            return api()->ok('Devolución exitosa', $devolucionEspecialArmaPersonal);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());;
        }
    }
}
