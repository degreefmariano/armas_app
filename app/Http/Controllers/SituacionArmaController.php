<?php

namespace App\Http\Controllers;

use App\Http\Requests\SituacionArma\CreateSituacionArmaRequest;
use App\Http\Requests\SituacionArma\UpdateSituacionArmaRequest;
use Illuminate\Http\Request;
use App\Repositories\Contracts\SituacionArmaInterface;

class SituacionArmaController extends Controller
{
    protected $repository;

    public function __construct(SituacionArmaInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function getSituacionesArma()
    { 
        try {
            $situacionesArma = $this->repository->getSituacionesArma();
            return api()->ok('Situaciones de armas', $situacionesArma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function createSituacionArma(CreateSituacionArmaRequest $request)    
    { 
        try {
            $situacionArma = $this->repository->createSituacionArma($request);
            return api()->ok('Alta exitosa', $situacionArma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function updateSituacionArma($situacionArmaId, UpdateSituacionArmaRequest $request)    
    { 
        try {
            $situacionArma = $this->repository->updateSituacionArma($situacionArmaId, $request);
            return api()->ok('Modificación exitosa', $situacionArma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

}
