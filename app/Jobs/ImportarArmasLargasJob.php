<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\ImportArmasJobs;
use App\Imports\ExcelArmasLargas;
use App\Models\ImportArmasExcel;
use App\Events\ImportArmasStatusMessage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportarArmasLargasJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $jobId = null;
    protected $tipoArma;
    protected $fechaAlta;
    protected $obs;
    protected $auth;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($tipoArma, $fechaAlta, $obs, $auth)
    {
        $this->tipoArma  = $tipoArma;
        $this->fechaAlta = $fechaAlta;
        $this->obs       = $obs;
        $this->auth      = $auth;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->jobInit();
        Log::info("INICIA IMPORT JOB");

        $fileName = $this->getTmpFileName();

        $this->readExcel($fileName, $this->tipoArma, $this->fechaAlta, $this->obs);

        $this->updateEndJob($this->getJobId(), 'OK');

        $this->moveFileToProcessed($fileName);


    }

    protected function jobInit()
    {
        $jobId = $this->getJobId();

        $this->updateStartJob($jobId);

        return $jobId;
    }

    protected function getJobId()
    {
        if ($this->jobId === null) {
            $jobId = $this->job->getJobId();
            Log::info("JOB ID AL INICIO " . $jobId);
            return $this->jobId = ImportArmasJobs::where('job_id', $jobId)
                ->pluck('id')
                ->first();
            Log::info("JOB ID OBTENIDO " . $this->jobId);
        }

        return $this->jobId;
    }

    protected function getTmpFileName()
    {
        $jobId = $this->getJobId();

        $tmpFileName = ImportArmasJobs::where('id', $jobId)
                                ->pluck('temp_file_name')
                                ->first();


        $tmpPath = storage_path("app/importacion_armas/tmp/" . $tmpFileName);

        Log::info("PATH FILE: " . $tmpPath);

        return $tmpPath;
    }

    protected function updateStartJob($jobId)
    {
        ImportArmasJobs::where('id', $jobId)->update(['start_job' => now()]);
    }

    public function readExcel(string $tmpFileName, int $tipoArma, $fechaAlta, string $obs): bool
    {
        try {
            $reader = IOFactory::createReader('Xlsx');
            $spreadsheet = $reader->load($tmpFileName);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            $import = new ExcelArmasLargas($tipoArma, $fechaAlta, $obs);
            $response = $import->batchInsert($sheetData, $tipoArma, $fechaAlta, $obs);

            if ($response != 'OK') {

                Log::error("ERROR AL IMPORTAR ARCHIVO: [$tmpFileName] " . $response);
                $this->updateEndJob($this->getJobId(), 'FALLIDO', strtoupper($response));
                return false;

            } else {
                $recordsError = ImportArmasExcel::where('estado', 'ERROR')->count();

                if ($recordsError > 0) {
                    $errorFileName = $import->exportErrorRecords($tmpFileName);
                    $jobId = $this->getJobId();
                    $this->updateErrorFileJob($jobId, $errorFileName);
                }
                return true;
            }

        } catch (\Exception $e) {
            Log::error("NO SE ENCONTRO EL ARCHIVO: [$tmpFileName] " . $e->getMessage());

            $this->updateEndJob($this->getJobId(), 'FALLIDO', "NO SE ENCONTRO EL ARCHIVO: [$tmpFileName]");

            return false;
        }
    }

    protected function updateEndJob($jobId, $status = 'OK', $comments = null)
    {
        $recordsError = ImportArmasExcel::where('estado', 'ERROR')->count();
        $recordsOk = ImportArmasExcel::where('estado', 'OK')->count();

        ImportArmasJobs::where('id', $jobId)
            ->update([
                'end_job' => now(),
                'status' => $status,
                'comments' => $comments,
                'records_error' => $recordsError,
                'records_ok' => $recordsOk
            ]);
    }

    protected function moveFileToProcessed($tmpFileName)
    {
        $newPath = 'importacion_armas/proc/' . basename($tmpFileName);

        File::move($tmpFileName, storage_path('app/' . $newPath));

        Log::info("ARCHIVO MOVIDO A: " . $newPath);

        if ($newPath) {
            event(new ImportArmasStatusMessage('Fin del proceso de importación de armas largas', $this->auth ));
        }
    }

    protected function updateErrorFileJob($jobId, $errorFileName)
    {
        ImportArmasJobs::where('id', $jobId)
            ->update(['error_file_name' => $errorFileName]);
    }
}
