<?php

namespace App\Http\Controllers;

use App\Models\Arma;
use App\Models\CortaLargaArma;
use App\Models\SituacionArma;
use App\Models\SubSituacionArma;
use App\Models\Subunidad;
use App\Models\Unidad;
use App\Models\VistaArma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstadisticaController extends Controller
{
    public function getEstadisticaSubSituacionesArmaUd()
    { // todas las UD
        try {
            $userCodUd = Auth('sanctum')->user()->cod_ud;
            $resultados =
                SubSituacionArma::leftJoin('arma', function ($join) use ($userCodUd) {
                    $join->on('subsituacion.id', '=', 'arma.sub_situacion')
                        ->where('ud_ar', $userCodUd);
                })
                ->select('subsituacion.descripcion', DB::raw('COALESCE(count(arma.sub_situacion), 0) as total'))
                ->groupBy('subsituacion.descripcion')
                ->get();

            return api()->ok('Resultados', $resultados);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function getEstadisticaSituacionesArmaUd() 
    { // todas las UD
        try {
            $userCodUd = Auth('sanctum')->user()->cod_ud;
            $resultados =
                SituacionArma::leftJoin('arma', function ($join) use ($userCodUd) {
                    $join->on('situacion.cod_situacion', '=', 'arma.situacion')
                        ->where('ud_ar', $userCodUd);
                })
                ->whereIn('situacion.cod_situacion', SituacionArma::SITUACIONES)
                ->select('situacion.nom_situacion', DB::raw('COALESCE(count(arma.situacion), 0) as total'))
                ->groupBy('situacion.nom_situacion')
                ->get();

            return api()->ok('Resultados', $resultados);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function getEstadisticaCortaLargaArmaUd()
    { // todas las UD
        try {
            $userCodUd = Auth('sanctum')->user()->cod_ud;
            $resultados =
                CortaLargaArma::leftJoin('arma', function ($join) use ($userCodUd) {
                    $join->on('corta_larga.id', '=', 'arma.arma_corta_larga')
                        ->where('ud_ar', $userCodUd)
                        ->where('situacion', SituacionArma::DEPOSITO);
                })
                ->whereIn('arma_corta_larga', CortaLargaArma::CORTA_LARGA)
                ->select('corta_larga.descripcion', DB::raw('COALESCE(count(arma.arma_corta_larga), 0) as total'))
                ->groupBy('corta_larga.descripcion')
                ->get();

            return api()->ok('Resultados', $resultados);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function getEstadisticaEnServicioArmaGral()
    { // solo el D4
        try {
            $resultados = Arma::where('situacion', SituacionArma::SERVICIO)
                ->select('ud_ar', DB::raw('COALESCE(count(situacion), 0) as total'))
                ->groupBy('ud_ar') 
                ->get();
            foreach ($resultados as $r) {
                $r->ud_ar = trim(Unidad::unidadId($r->ud_ar));
            }

            return api()->ok('Resultados', $resultados);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function getEstadisticaEnServicioArmaLargaUd()
    { // todas las UD
        try {
            $userCodUd = Auth('sanctum')->user()->cod_ud;
            $resultados =
                Arma::where('arma_corta_larga', CortaLargaArma::LARGA)
                ->where('ud_ar', $userCodUd)
                ->where('situacion', SituacionArma::SERVICIO)
                ->select('subud_ar', DB::raw('COALESCE(count(arma.arma_corta_larga), 0) as total'))
                ->groupBy('subud_ar')
                ->get();

            foreach ($resultados as $r) {
                $r->subud_ar = trim(Subunidad::subunidadId($r->subud_ar));
            }

            return api()->ok('Resultados', $resultados);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function getEstadisticaEnDepositoArmaGral()
    { // solo el D4
        try {
            $resultados = Arma::where('situacion', SituacionArma::DEPOSITO)
                ->select('ud_ar', DB::raw('COALESCE(count(situacion), 0) as total'))
                ->groupBy('ud_ar') 
                ->get();
            foreach ($resultados as $r) {
                $r->ud_ar = trim(Unidad::unidadId($r->ud_ar));
            }

            return api()->ok('Resultados', $resultados);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function getEstadisticaTotalArmaGral()
    { // solo el D4
        try {
            $resultados = Arma::count();
            return api()->ok('Resultados', $resultados);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }
}
