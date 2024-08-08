<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface SituacionArmaInterface
{
    public function getSituacionesArma();

    public function createSituacionArma(Request $request);

    public function updateSituacionArma($situacionArmaId, Request $request);
    
}
