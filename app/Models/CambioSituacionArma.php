<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CambioSituacionArma extends Model
{
    use HasFactory;

    protected $table = 'cambio_situacion';
    protected $primaryKey = 'nro_ficha';
    protected $connection = 'pgsql';

    public static function getTrabajoRealizado($numero, $tipo, $marca, $calibre, $situacion)
    {
        $trabajo_realizado = CambioSituacionArma::select('trabajo_realizado')
            ->where([
                'nro_arma'          => $numero,
                'cod_tipo_arma'     => $tipo,
                'cod_marca'         => $marca,
                'calibre_principal' => $calibre,
                'situacion'         => $situacion
            ])
            ->orderBy('nro_ficha', 'DESC')
            ->first();

        if ($trabajo_realizado) {
            $trabajo_realizado = $trabajo_realizado->trabajo_realizado;
        } else {
            $trabajo_realizado = '';
        }

        return $trabajo_realizado;
    }

    public static function getSustraccionExtravioSecuestro($numero, $tipo, $marca, $calibre, $situacion)
    {
        return CambioSituacionArma::select
            (
                'fecha_movimiento',
                'fecha_hecho',
                'lugar_hecho',
                'dep_interviniente',
                'fiscalia_interviniente',
                'victimas',
                'imputados',
                'caratula', 
                'lugar_deposito',
                'cuij'
            )
            ->where([
                'nro_arma'          => $numero,
                'cod_tipo_arma'     => $tipo,
                'cod_marca'         => $marca,
                'calibre_principal' => $calibre,
                'situacion'         => $situacion,
            ])
            ->orderBy('nro_ficha', 'DESC')
            ->first();
    }

    public static function getHistorialSituaciones($numero, $tipo, $marca, $calibre)
    {
        return CambioSituacionArma::
            select(
                'situacion.cod_situacion',
                'situacion.nom_situacion', 
                'fecha_movimiento', 
                'obs',
                'funcionario',
                'unidad',
                'subunidad'
                )
            ->join('situacion', 'cambio_situacion.situacion', 'situacion.cod_situacion')
            ->where([
                'nro_arma' => $numero,
                'cod_tipo_arma' => $tipo,
                'cod_marca' => $marca,
                'calibre_principal' => $calibre,
            ])
            ->orderBy('nro_ficha', 'DESC')
            ->get();
    }

    public static function newCambioSituacionArmaEntregaPersonal($arma, $personalArma)
    { 
        $cambioSituacion = new CambioSituacionArma();
        $cambioSituacion->situacion              = Arma::SITUACION_SERVICIO;
        $cambioSituacion->nro_arma               = $arma->nro_arma;
        $cambioSituacion->cod_tipo_arma          = $arma->cod_tipo_arma;
        $cambioSituacion->cod_marca              = $arma->cod_marca;
        $cambioSituacion->calibre_principal      = $arma->cod_calibre_principal;
        $cambioSituacion->fecha_movimiento       = $personalArma->fecha_entrega;
        $cambioSituacion->obs                    = $personalArma->obs;
        $cambioSituacion->id_usr                 = Auth('sanctum')->user()->id;
        $cambioSituacion->ud                     = Auth('sanctum')->user()->cod_ud;
        $cambioSituacion->seccion_operador       = Auth('sanctum')->user()->cod_subud;
        $cambioSituacion->funcionario            = $personalArma->legajo;

        $cambioSituacion->save();

        return $cambioSituacion;
    }

    public static function newCambioSituacionArmaDevuelvePersonal($request, $arma)
    {
        $cambioSituacion = new CambioSituacionArma();
        $cambioSituacion->situacion              = Arma::DEPOSITO; 
        $cambioSituacion->nro_arma               = $arma->nro_arma;
        $cambioSituacion->cod_tipo_arma          = $arma->cod_tipo_arma;
        $cambioSituacion->cod_marca              = $arma->cod_marca;
        $cambioSituacion->calibre_principal      = $arma->cod_calibre_principal;
        $cambioSituacion->fecha_movimiento       = Carbon::now()->format('d-m-Y');
        $cambioSituacion->obs                    = $request->obs;
        $cambioSituacion->id_usr                 = Auth('sanctum')->user()->id;
        $cambioSituacion->ud                     = Auth('sanctum')->user()->cod_ud;
        $cambioSituacion->seccion_operador       = Auth('sanctum')->user()->cod_subud;
        $cambioSituacion->sub_situacion          = Arma::SUBSITUACION_CREATE; //CONSULTAR
        $cambioSituacion->unidad                 = $arma->ud;
        $cambioSituacion->subunidad              = $arma->seccion_operador;

        $cambioSituacion->save();

        return $cambioSituacion;
    }

    public static function newCambioSituacionArmaDevuelve($request, $arma)
    {
        $cambioSituacion = new CambioSituacionArma();
        $cambioSituacion->situacion              = (Auth('sanctum')->user()->cod_ud = Arma::UD_AR) ? Arma::DEVOLUCION_UD_D4 : Arma::DEPOSITO; 
        $cambioSituacion->nro_arma               = $arma->nro_arma;
        $cambioSituacion->cod_tipo_arma          = $arma->cod_tipo_arma;
        $cambioSituacion->cod_marca              = $arma->cod_marca;
        $cambioSituacion->calibre_principal      = $arma->cod_calibre_principal;
        $cambioSituacion->fecha_movimiento       = Carbon::now()->format('Y-m-d');
        $cambioSituacion->obs                    = $request->obs;
        $cambioSituacion->id_usr                 = Auth('sanctum')->user()->id;
        $cambioSituacion->ud                     = Auth('sanctum')->user()->cod_ud;
        $cambioSituacion->seccion_operador       = Auth('sanctum')->user()->cod_subud;
        $cambioSituacion->save();

        return $cambioSituacion;
    }

    public static function getSituacionHistorialArma($request)
    {
        $arma = Arma::where('nro_ficha', $request->nro_ficha)->first();
        if ($arma) {
            return CambioSituacionArma::select('situacion.nom_situacion', 'fecha_movimiento', 'obs')
                ->join('situacion', 'cambio_situacion.situacion', 'situacion.cod_situacion')
                ->where([
                    'nro_arma' => $arma->nro_arma,
                    'cod_tipo_arma' => $arma->cod_tipo_arma,
                    'cod_marca' => $arma->cod_marca,
                    'calibre_principal' => $arma->cod_calibre_principal
                ])
                ->orderBy('nro_ficha', 'DESC')
                ->get();
        }
    }

    public static function newArmaEnDeposito($arma)
    { 
        $cambioSituacion = new CambioSituacionArma();
        $cambioSituacion->situacion              = Arma::ALTA_EN_DEPOSITO;
        $cambioSituacion->nro_arma               = $arma->nro_arma;
        $cambioSituacion->cod_tipo_arma          = $arma->cod_tipo_arma;
        $cambioSituacion->cod_marca              = $arma->cod_marca;
        $cambioSituacion->calibre_principal      = $arma->cod_calibre_principal;
        $cambioSituacion->fecha_movimiento       = $arma->fecha_alta;
        $cambioSituacion->obs                    = $arma->obs;
        $cambioSituacion->id_usr                 = Auth('sanctum')->user()->id;
        $cambioSituacion->ud                     = Auth('sanctum')->user()->cod_ud;
        $cambioSituacion->seccion_operador       = Auth('sanctum')->user()->cod_subud;
        $cambioSituacion->sub_situacion          = $arma->sub_situacion;
        $cambioSituacion->unidad                 = $arma->ud;
        $cambioSituacion->subunidad              = $arma->seccion_operador;
        

        $cambioSituacion->save();

        return $cambioSituacion;
    }

    public static function getObs($numero, $tipo, $marca, $calibre, $situacion)
    {
        return CambioSituacionArma::select(
                'obs as observaciones'
                )
            ->where([
                'nro_arma'          => $numero,
                'cod_tipo_arma'     => $tipo,
                'cod_marca'         => $marca,
                'calibre_principal' => $calibre,
                'situacion'         => $situacion
            ])
            ->orderBy('nro_ficha', 'DESC')
            ->first();
    }
}
