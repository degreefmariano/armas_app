<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface MarcaArmaInterface
{
    public function getMarcasArma();

    public function createMarcaArma(Request $request);

    public function updateMarcaArma($marcaArmaId, Request $request);
    
}
