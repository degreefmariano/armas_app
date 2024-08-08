<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface CuibArmaInterface
{
    public function getCuibsArma(Request $request);

    public function createCuibArma(Request $request);

}
