<?php

namespace App\Http\Controllers;

use App\Http\Requests\Importar\ImportarArmaRequest;
use App\Http\Requests\Importar\ImportarArmaLargaRequest;
use App\Http\Requests\Jobs\DownloadExcelRequest;
use App\Http\Requests\Jobs\JobsListadoRequest;
use App\Http\Requests\Jobs\JobIdRequest;
use App\Models\ImportArmasJobs;
use App\Repositories\Contracts\ImportarArmaInterface;
use Illuminate\Http\Request;

class ImportarArmaController extends Controller
{
    protected $repository;

    public function __construct(ImportarArmaInterface $repository)
    {
        $this->repository = $repository;
    }

    public function importarArmas(ImportarArmaRequest $request)
    {
        try {
            $importarArmas = $this->repository->importarArmas($request);
            return api()->ok('Documento de armas cortas en cola de espera satisfactoriamente!!', $importarArmas);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function importarArmasLargas(ImportarArmaLargaRequest $request)
    {
        try {
            $importarArmasLargas = $this->repository->importarArmasLargas($request);
            return api()->ok('Documento de armas largas en cola de espera satisfactoriamente!!', $importarArmasLargas);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function downloadTemplateCortas()
    {
        return $this->repository->downloadTemplateCortas();
    }

    public function downloadTemplateLargas()
    {
        return $this->repository->downloadTemplateLargas();
    }

    public function listadoProcesos(JobsListadoRequest $request)
    {
        try {
            $listadoProcesosModel = $this->repository->listadoProcesos($request);
            return api()->ok('Listado de procesos', $listadoProcesosModel);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function procesoPorId(int $jobId, JobIdRequest $request)
    { 
        try {
            $ProcesoModel = $this->repository->procesoPorId($jobId);
            return api()->ok('Proceso', $ProcesoModel);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function downloadExcel(int $jobId, DownloadExcelRequest $request)
    { 
        return $this->repository->downloadExcel($jobId, $request);
    }
}
