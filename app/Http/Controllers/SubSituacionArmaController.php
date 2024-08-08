<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubSituacionArma\SituacionRequest;
use Illuminate\Http\Request;
use App\Repositories\Contracts\SubSituacionArmaInterface;

class SubSituacionArmaController extends Controller
{
    protected $repository;

    public function __construct(SubSituacionArmaInterface $repository)
    {
        $this->repository = $repository;
    }
    

    public function getSubSituacionesArma(SituacionRequest $request)
    {
        try {
            $subsituacionesArma = $this->repository->getSubSituacionesArma($request);
            return api()->ok('Resultados', $subsituacionesArma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        } 
    }
}
