<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface ReporteArmaInterface
{
    public function exportarReporteArmas(Request $request);
    public function descargarReporteArmas();
}
