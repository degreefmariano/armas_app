<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface CambioUnidadPersonalInterface
{
    public function getPersonalCambioUnidad(Request $request);

    public function updatePersonalCambioUnidad(int $ficha, Request $request);
}
