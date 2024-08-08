<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface SubSituacionArmaInterface
{
    public function getSubSituacionesArma(Request $request);

}
