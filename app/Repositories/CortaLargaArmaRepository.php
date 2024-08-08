<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\CortaLargaArma;
use Illuminate\Http\Request;
use App\Repositories\Contracts\CortaLargaArmaInterface;
use App\Http\Resources\CortaLargaArma\CortaLargaArmaCollectionResource;

final class CortaLargaArmaRepository implements CortaLargaArmaInterface
{
    protected CortaLargaArma $cortaLargaArmaModel;

    public function __construct(CortaLargaArma $cortaLargaArmaModel)
    {
        $this->cortaLargaArmaModel = $cortaLargaArmaModel;
    }

    public function getCortaLargaArma()
    {
        return new CortaLargaArmaCollectionResource($this->cortaLargaArmaModel->getCortaLargaArma());
    }

    
}
