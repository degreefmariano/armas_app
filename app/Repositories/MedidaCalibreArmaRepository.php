<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\MedidaCalibreArma;
use Illuminate\Http\Request;
use App\Repositories\Contracts\MedidaCalibreArmaInterface;
use App\Http\Resources\MedidaCalibreArma\MedidaCalibreArmaCollectionResource;

final class MedidaCalibreArmaRepository implements MedidaCalibreArmaInterface
{
    protected MedidaCalibreArma $medidaCalibreArmaModel;

    public function __construct(MedidaCalibreArma $medidaCalibreArmaModel)
    {
        $this->medidaCalibreArmaModel = $medidaCalibreArmaModel;
    }

    public function getMedidaCalibreArma()
    {
        return new MedidaCalibreArmaCollectionResource($this->medidaCalibreArmaModel->getMedidaCalibreArma());
    }

    
}
