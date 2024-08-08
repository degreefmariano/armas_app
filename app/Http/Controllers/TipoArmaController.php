<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoArma\CreateTipoArmaRequest;
use App\Http\Requests\TipoArma\UpdateTipoArmaRequest;
use Illuminate\Http\Request;
use App\Repositories\Contracts\TipoArmaInterface;

class TipoArmaController extends Controller
{
    protected $repository;

    public function __construct(TipoArmaInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function getTiposArma()
    {
        try {
            $tiposArma = $this->repository->getTiposArma();
            return api()->ok('Tipos de armas', $tiposArma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function createTipoArma(CreateTipoArmaRequest $request)    
    {
        try {
            $tiposArma = $this->repository->createTipoArma($request);
            return api()->ok('Alta exitosa', $tiposArma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function updateTipoArma($tipoArmaId, UpdateTipoArmaRequest $request)    
    {
        try {
            $tiposArma = $this->repository->updateTipoArma($tipoArmaId, $request);
            return api()->ok('Modificación exitosa', $tiposArma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }
}