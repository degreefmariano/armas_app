<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\UsoArma;
use Illuminate\Http\Request;
use App\Repositories\Contracts\UsoArmaInterface;
use App\Http\Resources\UsosArma\UsosArmaCollectionResource;

final class UsoArmaRepository implements UsoArmaInterface
{
    protected UsoArma $usoArmaModel;

    public function __construct(UsoArma $usoArmaModel)
    {
        $this->usoArmaModel = $usoArmaModel;
    }

    public function getUsosArma()
    {
        return new UsosArmaCollectionResource($this->usoArmaModel->getUsosArma());
    }

    
}
