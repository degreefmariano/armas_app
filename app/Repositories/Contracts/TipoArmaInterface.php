<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface TipoArmaInterface
{
    public function getTiposArma();

    public function createTipoArma(Request $request);

    public function updateTipoArma($tipoArmaId, Request $request);
    
}
