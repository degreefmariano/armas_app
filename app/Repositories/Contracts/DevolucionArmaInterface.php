<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface DevolucionArmaInterface
{
    public function devolverArmasMasiva(Request $request);

    public function getDevolucionArmaTipo(Request $request);

}
