<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\CalibreArma;
use Illuminate\Http\Request;
use App\Repositories\Contracts\CalibreArmaInterface;
use App\Http\Resources\CalibresArma\CalibresArmaCollectionResource;
use App\Http\Resources\CalibresArma\CalibresArmaResource;

final class CalibreArmaRepository implements CalibreArmaInterface
{
    protected CalibreArma $calibreArmaModel;

    public function __construct(CalibreArma $calibreArmaModel)
    {
        $this->calibreArmaModel = $calibreArmaModel;
    }

    public function getCalibresArma()
    {
        return new CalibresArmaCollectionResource($this->calibreArmaModel->getCalibresArma());
    }

    public function createCalibreArma(Request $request)
    { 
        return new CalibresArmaResource($this->calibreArmaModel->createCalibreArma($request));
        
    } 

    public function updateCalibreArma($calibreArmaId, Request $request)
    { 
        return new CalibresArmaResource($this->calibreArmaModel->updateCalibreArma($calibreArmaId, $request));
        
    }
}
