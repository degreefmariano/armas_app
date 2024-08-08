<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\ImportArmasJobs;
use Illuminate\Support\Facades\Bus;
use App\Jobs\ImportarArmasCortasJob;
use App\Jobs\ImportarArmasLargasJob;
use Illuminate\Support\Facades\Response;
use App\Events\ImportArmasStatusMessage;
use App\Http\Resources\Jobs\JobsPorIdResource;
use App\Repositories\Contracts\ImportarArmaInterface;
use App\Http\Resources\Jobs\JobsListCollectionResource;

final class ImportarArmaRepository implements ImportarArmaInterface
{
    protected ImportArmasJobs $procesosModel;

    public function __construct(ImportArmasJobs $procesosModel)
    {
        $this->procesosModel = $procesosModel;
    }

    public function importarArmas(Request $request)
    {
        $tipoArma = $request->tipo;
        $fechaAlta = $request->fecha_alta;
        $obs = $request->obs;

        $file = $request->file('file');
        $originalFileName = $file->getClientOriginalName();

        $auth =  Auth('sanctum')->user();
        $job = new ImportarArmasCortasJob($tipoArma, $fechaAlta, $obs, $auth);
        $jobId = Bus::dispatch($job);
        event(new ImportArmasStatusMessage('Se inicio proceso de importación de armas cortas', $auth));

        $tmpFileName = $this->storeArmasFile($request, $jobId);

        $this->saveImportarArmasJob($jobId, $originalFileName, $tipoArma, $tmpFileName);

        return true;
    }

    public function importarArmasLargas(Request $request)
    {
        $tipoArma = $request->tipo;
        $fechaAlta = $request->fecha_alta;
        $obs = $request->obs;

        $file = $request->file('file');
        $originalFileName = $file->getClientOriginalName();

        $auth =  Auth('sanctum')->user();
        $job = new ImportarArmasLargasJob($tipoArma, $fechaAlta, $obs, $auth);
        $jobId = Bus::dispatch($job);
        event(new ImportArmasStatusMessage('Se inicio proceso de importación de armas largas', $auth));

        $tmpFileName = $this->storeArmasFile($request, $jobId);

        $this->saveImportarArmasLargasJob($jobId, $originalFileName, $tipoArma, $tmpFileName);

        return true;
    }

    protected function saveImportarArmasJob($jobId, $originalFileName, $tipoArma, $tmpFileName)
    {
        $importArmasJob = new ImportArmasJobs();

        $importArmasJob->job_id             = $jobId;
        $importArmasJob->tipo               = $tipoArma;
        $importArmasJob->user_id            = Auth('sanctum')->user()->id;
        $importArmasJob->queue              = now();
        $importArmasJob->status             = ImportArmasJobs::ESTADO_PENDIENTE;
        $importArmasJob->original_file_name = $originalFileName;
        $importArmasJob->temp_file_name     = $tmpFileName;

        $importArmasJob->save();
    }

    protected function storeArmasFile($request, $jobId)
    {
        $file = $request->file('file');

        $formattedDateTime = Carbon::now()->format('YmdHi');

        $tmpFileName = $formattedDateTime . '_' . $jobId . '_' . $file->getClientOriginalName();

        $file->storeAs('importacion_armas/tmp', $tmpFileName);

        return $tmpFileName;
    }

    protected function saveImportarArmasLargasJob($jobId, $originalFileName, $tipoArma, $tmpFileName)
    {
        $importArmasJob = new ImportArmasJobs();

        $importArmasJob->job_id             = $jobId;
        $importArmasJob->tipo               = $tipoArma;
        $importArmasJob->user_id            = Auth('sanctum')->user()->id;
        $importArmasJob->queue              = now();
        $importArmasJob->status             = ImportArmasJobs::ESTADO_PENDIENTE;
        $importArmasJob->original_file_name = $originalFileName;
        $importArmasJob->temp_file_name     = $tmpFileName;

        $importArmasJob->save();
    }

    protected function storeArmasLargasFile($request, $jobId)
    {
        $file = $request->file('file');

        $formattedDateTime = Carbon::now()->format('YmdHi');

        $tmpFileName = $formattedDateTime . '_' . $jobId . '_' . $file->getClientOriginalName();

        $file->storeAs('importacion_armas/tmp', $tmpFileName);

        return $tmpFileName;
    }

    public function downloadTemplateCortas()
    {
        $templatePath = public_path('template/template_armas_cortas.xlsx');
        if (!\File::exists($templatePath)) {
            return response()->json(['error' => 'El archivo no existe.'], 404);
        }
        return Response::download($templatePath);
    }

    public function downloadTemplateLargas()
    {
        $templatePath = public_path('template/template_armas_largas.xlsx');
        if (!\File::exists($templatePath)) {
            return response()->json(['error' => 'El archivo no existe.'], 404);
        }
        return Response::download($templatePath);
    }

    public function listadoProcesos(Request $request)
    {
        return new JobsListCollectionResource($this->procesosModel->listadoProcesos($request));
    }

    public function procesoPorId(int $jobId)
    {
        return new JobsPorIdResource($this->procesosModel->procesoPorId($jobId));
    }

    public function downloadExcel($jobId, $request)
    {
        if ($request->tipo == "original") {
            $file_name = ImportArmasJobs::where('id' , $jobId)->pluck('temp_file_name')->first();
            $file_path = storage_path('app/importacion_armas/proc/' . $file_name);

        }

        if ($request->tipo == "error") {
            $file_name = ImportArmasJobs::where('id' , $jobId)->pluck('error_file_name')->first();
            $file_path = storage_path('app/importacion_armas/err/' . $file_name);
        }

        if ($request->tipo == "fallido") {
            $file_name = ImportArmasJobs::where('id' , $jobId)->pluck('temp_file_name')->first();
            $file_path = storage_path('app/importacion_armas/tmp/' . $file_name);
        }

        if (!\File::exists($file_path)) {
           return response()->json(['error'=>'El archivo no existe'], 404);
        }

        return Response::download($file_path);
    }
}
