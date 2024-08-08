<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstadoArma\CreateEstadoArmaRequest;
use App\Http\Requests\EstadoArma\UpdateEstadoArmaRequest;
use Illuminate\Http\Request;
use App\Repositories\Contracts\EstadoArmaInterface;

class EstadoArmaController extends Controller
{
    protected $repository;

    public function __construct(EstadoArmaInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function getEstadosArma()
    {
        try {
            $estadosArma = $this->repository->getEstadosArma();
            return api()->ok('Estados de arma', $estadosArma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function createEstadoArma(CreateEstadoArmaRequest $request)    
    { 
        try {
            $estadoArma = $this->repository->createEstadoArma($request);
            return api()->ok('Alta exitosa', $estadoArma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function updateEstadoArma($estadoArmaId, UpdateEstadoArmaRequest $request)    
    { 
        try {
            $estadoArma = $this->repository->updateEstadoArma($estadoArmaId, $request);
            return api()->ok('Modificación exitosa', $estadoArma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }
}
