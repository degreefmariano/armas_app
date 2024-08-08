<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface CalibreArmaInterface
{
    public function getCalibresArma();

    public function createCalibreArma(Request $request);

    public function updateCalibreArma($calibreArmaId, Request $request);
    
}
