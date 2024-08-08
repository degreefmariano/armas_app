<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\VistaArma;
use App\Models\CalibreArma;
use App\Models\CortaLargaArma;
use App\Models\EstadoArma;
use App\Models\MarcaArma;
use App\Models\SituacionArma;
use App\Models\SubSituacionArma;
use App\Models\Subunidad;
use App\Models\TipoArma;
use App\Models\Unidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\ReporteArmaInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

final class ReporteArmaRepository implements ReporteArmaInterface
{
    protected VistaArma $reporteModel;

    public function __construct(VistaArma $reporteModel)
    {
        $this->reporteModel = $reporteModel;
    }

    public function exportarReporteArmas(Request $request)
    {
        $cabeceraFiltros = [];
        
        Log::info("INICIA REPORTE ARMAS");

        $query = VistaArma::select(
                'nro_arma',
                'nom_tipo_arma',
                'nom_marca_arma',
                'nom_cal_principal',
                'modelo',
                'corta_larga',
                'uso',
                'nom_estado',
                'nom_situacion',
                'descripcion',
                'vista_arma.nom_subud',
                'nlegajo_ps',
                DB::raw('TRIM(nombre_ps) as nombre'),
                'cantidad_cargador',
                'cantidad_municion',
                'ud_ar',
                'cod_tipo_arma',
                'cod_marca',
                'cod_calibre_principal'
            )
            ->leftJoin('personal', function ($join) {
                $join->on('vista_arma.personal_legajo', '=', 'personal.nlegajo_ps');
            })
            ->orderBy('vista_arma.ud_ar', 'asc');

        if (!empty($request->cod_tipo_arma) AND !is_null($request->cod_tipo_arma)) {
            $query->where('cod_tipo_arma', $request->cod_tipo_arma);
            $tipoArma = 'TIPO ARMA: ' . trim(TipoArma::where('id', $request->cod_tipo_arma)->first()->descripcion);
            array_push($cabeceraFiltros, $tipoArma);
        }

        if (!empty($request->cod_marca) AND !is_null($request->cod_marca)) {
            $query->where('cod_marca', $request->cod_marca);
            $marcaArma = 'MARCA ARMA: ' . trim(MarcaArma::where('id', $request->cod_marca)->first()->descripcion);
            array_push($cabeceraFiltros, $marcaArma);
        }

        if (!empty($request->cod_calibre_principal) AND !is_null($request->cod_calibre_principal)) {
            $query->where('cod_calibre_principal', $request->cod_calibre_principal);
            $calibreArma = 'CALIBRE: ' . trim(CalibreArma::where('id', $request->cod_calibre_principal)->first()->descripcion);
            array_push($cabeceraFiltros, $calibreArma);
        }

        if (!empty($request->estado) AND !is_null($request->estado)) {
            $query->where('estado', $request->estado);
            $estadoArma = 'ESTADO ARMA: ' . trim(EstadoArma::where('cod_estado', $request->estado)->first()->nom_estado);
            array_push($cabeceraFiltros, $estadoArma);
        }

        if (!empty($request->situacion) AND !is_null($request->situacion)) {
            $query->where('situacion', $request->situacion);
             $situacionArma = 'SITUACION: ' . trim(SituacionArma::where('cod_situacion', $request->situacion)->first()->nom_situacion);
            array_push($cabeceraFiltros, $situacionArma);
        }

        if (!empty($request->subsituacion) AND !is_null($request->subsituacion)) {
            $query->where('sub_situacion', $request->subsituacion);
            $subSituacionArma = 'SUB SITUACION: ' . trim(SubSituacionArma::where('id', $request->subsituacion)->first()->descripcion);
            array_push($cabeceraFiltros, $subSituacionArma);
        }

        if (!empty($request->arma_corta_larga) AND !is_null($request->arma_corta_larga)) {
            $query->where('arma_corta_larga', $request->arma_corta_larga);
            $clasificacionArma = 'CLASIFICACION: ' . trim(CortaLargaArma::where('id', $request->arma_corta_larga)->first()->descripcion);
            array_push($cabeceraFiltros, $clasificacionArma);
        }

        if (!empty($request->subud_ar) AND !is_null($request->subud_ar)) {
            $query->where('subud_ar', $request->subud_ar);
            $subUnidadArma = 'SUB UNIDAD: ' . trim(Subunidad::where('cod_subud', $request->subud_ar)->first()->nom_subud);
            array_push($cabeceraFiltros, $subUnidadArma);
        }

        Log::info("FINALIZO CONSULTA A LA BASE DE DATOS");

        $unidades = Unidad::pluck('nom_ud', 'cod_ud');
        
        $spreadsheet = new Spreadsheet();

        if (!empty($request->ud_ar) AND !is_null($request->ud_ar)) {

            $query->where('ud_ar', $request->ud_ar);

            $results = $query->get();
            
            foreach ($results as $resu) {
                $resu->nlegajo_ps = $resu->nlegajo_ps.' - '.$resu->nombre; 
            }
           
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle($unidades[$request->ud_ar]); 

            $cabeceraTotal = 'TOTAL DE REGISTROS: ' . $results->count();
            $sheet->setCellValue('A1', $cabeceraTotal);

            $cabeceraTexto = 'RESULTADOS POR: ' . implode(', ', $cabeceraFiltros);
            $sheet->setCellValue('A2', $cabeceraTexto);

            $sheet->fromArray([
                ['NRO ARMA', 'TIPO ARMA', 'MARCA ARMA', 'CALIBRE', 'MODELO', 'CLASIFICACION', 'USO', 'ESTADO ARMA', 'SITUACION', 'SUB SITUACION', 'SUB UNIDAD', 'PERSONAL ASIGNADO', 'CARGADORES', 'MUNICIONES']
            ], null, 'A3');

            $data = $results->map(function ($item) {
                return collect($item)->except(['nombre', 'ud_ar', 'cod_tipo_arma', 'cod_marca', 'cod_calibre_principal'])->all();
            });

            $sheet->fromArray($data->toArray(), null, 'A4', true, false);

        } else {
            
            $results = $query->get();
            $ud_ar_groups = $results->groupBy('ud_ar');
            
            $sheet = $spreadsheet->createSheet();
            $sheet->setTitle('Reporte general de armas');

            $rowIndex = 1;

            foreach ($ud_ar_groups as $ud_ar => $group) {
                $cabeceraTotal = 'TOTAL DE REGISTROS: ' . $group->count();
                $cabeceraTexto = 'RESULTADOS POR: ' . implode(', ', $cabeceraFiltros);

                $sheet->setCellValue('A' . $rowIndex, $cabeceraTotal);
                $rowIndex++;

                $sheet->setCellValue('A' . $rowIndex, $cabeceraTexto);
                $rowIndex++;

                $sheet->setCellValue('A' . $rowIndex, $unidades[$ud_ar]);
                $rowIndex++;
                
                $sheet->fromArray([
                    ['NRO ARMA', 'TIPO ARMA', 'MARCA ARMA', 'CALIBRE', 'MODELO', 'CLASIFICACION', 'USO', 'ESTADO ARMA', 'SITUACION', 'SUB SITUACION', 'SUB UNIDAD', 'PERSONAL ASIGNADO', 'CARGADORES', 'MUNICIONES']
                ], null, 'A' . $rowIndex);
                $rowIndex++;
                
                foreach ($group as $g) {
                    
                    $g->nlegajo_ps = (!is_null($g->nlegajo_ps) AND !is_null($g->nombre)) ? $g->nlegajo_ps.' - '.$g->nombre : "";
                    
                    $sheet->setCellValue('A' . $rowIndex, $g->nro_arma);
                    $sheet->setCellValue('B' . $rowIndex, $g->nom_tipo_arma);
                    $sheet->setCellValue('C' . $rowIndex, $g->nom_marca_arma);
                    $sheet->setCellValue('D' . $rowIndex, $g->nom_cal_principal);
                    $sheet->setCellValue('E' . $rowIndex, $g->modelo);
                    $sheet->setCellValue('F' . $rowIndex, $g->corta_larga);
                    $sheet->setCellValue('G' . $rowIndex, $g->uso);
                    $sheet->setCellValue('H' . $rowIndex, $g->nom_estado);
                    $sheet->setCellValue('I' . $rowIndex, $g->nom_situacion);
                    $sheet->setCellValue('J' . $rowIndex, $g->descripcion);
                    $sheet->setCellValue('K' . $rowIndex, $g->nom_subud);
                    $sheet->setCellValue('L' . $rowIndex, $g->nlegajo_ps);
                    $sheet->setCellValue('M' . $rowIndex, $g->cantidad_cargador);
                    $sheet->setCellValue('N' . $rowIndex, $g->cantidad_municion);

                    $rowIndex++;
                }

                // Dejar una fila en blanco después de imprimir la información de una unidad
                $rowIndex++;
            }
            $spreadsheet->removeSheetByIndex(0);
        }

        Log::info("FINALIZO ARMADO DE EXCEL");

        $fileName = 'reporte_armas.xlsx';
        $tempFilePath = storage_path('app/reportes/') . $fileName;

        $writer = new Xlsx($spreadsheet);
        $writer->save($tempFilePath);

        Log::info("FINALIZO GUARDADO DE EXCEL");

        Log::info("ARCHIVO GENERADO: " . $tempFilePath);

        return $fileName;
    }

    public function descargarReporteArmas()
    {
        $filePath = storage_path('app/reportes/reporte_armas.xlsx');
        
        if (!\File::exists($filePath)) {
            return response()->json(['error' => 'El archivo no existe.'], 404);
        }
        
        return Response::download($filePath)->deleteFileAfterSend(true);
    }
}