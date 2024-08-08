<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarcaArma\CreateMarcaArmaRequest;
use App\Http\Requests\MarcaArma\UpdateMarcaArmaRequest;
use Illuminate\Http\Request;
use App\Repositories\Contracts\MarcaArmaInterface;

class MarcaArmaController extends Controller
{
    protected $repository;

    public function __construct(MarcaArmaInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function getMarcasArma()
    {
        try {
            $marcasArma = $this->repository->getMarcasArma();
            return api()->ok('Marcas de armas', $marcasArma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function createMarcaArma(CreateMarcaArmaRequest $request)    
    {
        try {
            $marcaArma = $this->repository->createMarcaArma($request);
            return api()->ok('Alta exitosa', $marcaArma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function updateMarcaArma($marcaArmaId, UpdateMarcaArmaRequest $request)    
    { 
        try {
            $marcaArma = $this->repository->updateMarcaArma($marcaArmaId, $request);
            return api()->ok('Modificación exitosa', $marcaArma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }
}
