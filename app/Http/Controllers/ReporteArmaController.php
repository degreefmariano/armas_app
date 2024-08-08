<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\ReporteArmaInterface;
use App\Http\Requests\Exportar\ExportarReporteArmasRequest;

class ReporteArmaController extends Controller
{
    protected $repository;

    public function __construct(ReporteArmaInterface $repository)
    {
        $this->repository = $repository;
    }

    public function exportarReporteArmas(ExportarReporteArmasRequest $request)
    {
        try {
            $tempFilePath = $this->repository->exportarReporteArmas($request);
            return api()->ok('Reporte generado con exito', $tempFilePath);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function descargarReporteArmas()
    {
        return $this->repository->descargarReporteArmas();
    }
}
