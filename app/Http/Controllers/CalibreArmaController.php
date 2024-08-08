<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalibreArma\CreateCalibreArmaRequest;
use App\Http\Requests\CalibreArma\UpdateCalibreArmaRequest;
use Illuminate\Http\Request;
use App\Repositories\Contracts\CalibreArmaInterface;
use PhpParser\Node\Stmt\TryCatch;

class CalibreArmaController extends Controller
{
    protected $repository;

    public function __construct(CalibreArmaInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function getCalibresArma()
    {
        try {
            $calibresArma = $this->repository->getCalibresArma();
            return api()->ok('Calibres de arma', $calibresArma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function createCalibreArma(CreateCalibreArmaRequest $request)    
    { 
        try {
            $calibreArma = $this->repository->createCalibreArma($request);
            return api()->ok('Alta exitosa', $calibreArma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function updateCalibreArma($calibreArmaId, UpdateCalibreArmaRequest $request)    
    { 
        try {
            $calibreArma = $this->repository->updateCalibreArma($calibreArmaId, $request);
            return api()->ok('Modificación exitosa', $calibreArma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }
}
