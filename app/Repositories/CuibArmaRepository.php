<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\CuibArma;
use Illuminate\Http\Request;
use App\Repositories\Contracts\CuibArmaInterface;
use App\Http\Resources\CuibsArma\CuibsArmaResource;
use App\Http\Resources\CuibsArma\CuibsArmaCollectionResource;

final class CuibArmaRepository implements CuibArmaInterface
{
    protected CuibArma $cuibArmaModel;

    public function __construct(CuibArma $cuibArmaModel)
    {
        $this->cuibArmaModel = $cuibArmaModel;
    }

    public function getCuibsArma(Request $request)
    {
        return new CuibsArmaCollectionResource($this->cuibArmaModel->getCuibsArma($request));
    }

    public function createCuibArma(Request $request)
    { 
        return new CuibsArmaResource($this->cuibArmaModel->createCuibArma($request));
        
    } 

}
