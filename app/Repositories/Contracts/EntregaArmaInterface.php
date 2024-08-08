<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface EntregaArmaInterface
{
    public function getEntregaArmaTipo(Request $request);

    public function asignarArmaMasiva(Request $request);

    public function asignarArmaMasivaLargas(Request $request);
}
