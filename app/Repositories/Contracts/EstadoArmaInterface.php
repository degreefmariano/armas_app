<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface EstadoArmaInterface
{
    public function getEstadosArma();

    public function createEstadoArma(Request $request);

    public function updateEstadoArma($estadoArmaId, Request $request);
    
}
