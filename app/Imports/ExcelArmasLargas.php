<?php

namespace App\Imports;

use App\Models\ImportArmasExcel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelArmasLargas
{
    protected $data;
    protected $tipoArma;
    protected $fechaAlta;
    protected $obs;

    public function __construct($tipoArma, $fechaAlta, $obs)
    {
        $this->tipoArma  = $tipoArma;
        $this->fechaAlta = $fechaAlta;
        $this->obs       = $obs;
    }

    public function batchInsert($data, $tipoArma, $fechaAlta, $obs)
    {
        $insertData = [];
    
        ImportArmasExcel::truncate();
        
        foreach ($data as $key => $row) {

            if ($key == 1) {
                continue;
            }

            $serie = isset($row['A']) ? $row['A'] : null;
            $tipo = isset($row['B']) ? $row['B'] : null;
            $marca = isset($row['C']) ? $row['C'] : null;
            $calibre = isset($row['D']) ? $row['D'] : null;
            $modelo = isset($row['E']) ? $row['E'] : null;

            if (isset($row['A']) && isset($row['B']) && isset($row['C']) && isset($row['D']) && isset($row['E'])) {
                $insertData[] = [
                    'serie' => $serie,
                    'tipo' => $tipo,
                    'marca' => $marca,
                    'calibre' => $calibre,
                    'modelo' => $modelo
                ];
            } 
        }
    
        ImportArmasExcel::insert($insertData);

        $mensaje = "";
        try {

            DB::statement("CALL sp_import_armas_excel($tipoArma, '$fechaAlta', '$obs')");
            $mensaje = 'OK';
            return $mensaje;

        } catch (\Exception $e) {

            $errorMessage = $e->getMessage();
            $errorMessageLines = explode("\n", $errorMessage);
            
            foreach ($errorMessageLines as $line) {
                if (strpos($line, "DETAIL:") !== false) {
                    $mensaje = trim(substr($line, strpos($line, "DETAIL:") + 7));
                    break;
                }
            }
            
            if (isset($mensaje)) {
                return $mensaje;
            } 
            
            Log::error("ERROR AL IMPORTAR ARCHIVO: " . $mensaje);
        }

        // try {
        //     DB::statement("CALL sp_import_armas_excel($tipoArma)");
        // } catch (\Exception $e) {
        //     Log::error("Error al ejecutar el procedimiento almacenado: " . $e->getMessage());
        // }
    }

    public function getData()
    {
        return $this->data;
    }

    public function exportErrorRecords($tmpFileName)
    {
        $errorRecords = ImportArmasExcel::select('serie', 'tipo', 'marca', 'calibre', 'modelo','comentario')
            ->where('estado', 'ERROR')
            ->get();
    
        $fileNameWithoutExtension = pathinfo($tmpFileName, PATHINFO_FILENAME);
        $errorFileName = $fileNameWithoutExtension . '_err.xlsx';
        $directory = 'importacion_armas/err';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($errorRecords->toArray());

        $headings = ['serie', 'tipo', 'marca', 'calibre', 'modelo', 'comentario'];
        $sheet->fromArray([$headings], null, 'A1');

        $data = $errorRecords->toArray();
        $sheet->fromArray($data, null, 'A2');

        $writer = new Xlsx($spreadsheet);
        $writer->save(storage_path('app/' . $directory . '/' . $errorFileName));
    
        return $errorFileName;
    }
}
