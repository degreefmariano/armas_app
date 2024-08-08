<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CambioEstadoArma extends Model
{
    use HasFactory;

    protected $table = 'cambio_estado';
    protected $primaryKey = 'nro_ficha';
    protected $connection = 'pgsql';

    public static function getEstadoHistorialArma($request)
    { 
        $arma = Arma::where('nro_ficha', $request->nro_ficha)->first();
        if ($arma) {
            return CambioEstadoArma::select('estado.nom_estado', 'fecha_movimiento', 'obs')
            ->join('estado', 'cambio_estado.estado', 'estado.cod_estado')
            ->where([
                'nro_arma' => $arma->nro_arma,
                'cod_tipo_arma' => $arma->cod_tipo_arma,
                'cod_marca' => $arma->cod_marca,
                'cod_calibre_principal' => $arma->cod_calibre_principal
            ])
            ->orderBy('nro_ficha', 'DESC')
            ->get();
           
        }
    }

    public static function newCambioEstadoArmaDevuelvePersonal($request, $arma) 
    {    
        $cambioEstado = new CambioEstadoArma();
        $cambioEstado->estado                 = $request->estado; 
        $cambioEstado->nro_arma               = $arma->nro_arma;
        $cambioEstado->cod_tipo_arma          = $arma->cod_tipo_arma;
        $cambioEstado->cod_marca              = $arma->cod_marca;
        $cambioEstado->cod_calibre_principal  = $arma->cod_calibre_principal;
        $cambioEstado->fecha_movimiento       = Carbon::now()->format('Y-m-d');
        $cambioEstado->obs                    = $request->obs;
        $cambioEstado->id_usr                 = Auth('sanctum')->user()->id;
        $cambioEstado->ud                     = Auth('sanctum')->user()->cod_ud;
        $cambioEstado->seccion_operador       = Auth('sanctum')->user()->cod_subud;
        $cambioEstado->save();

    }

    public static function newArmaAltaEnDeposito($arma)
    {
        $cambioEstado = new CambioEstadoArma();
        $cambioEstado->nro_ficha              = $arma->nro_ficha;
        $cambioEstado->estado                 = $arma->estado;
        $cambioEstado->nro_arma               = $arma->nro_arma;
        $cambioEstado->cod_tipo_arma          = $arma->cod_tipo_arma;
        $cambioEstado->cod_marca              = $arma->cod_marca;
        $cambioEstado->cod_calibre_principal  = $arma->cod_calibre_principal;
        $cambioEstado->fecha_movimiento       = $arma->fecha_alta;
        $cambioEstado->obs                    = 'ALTA EN DEPOSITO';
        $cambioEstado->id_usr                 = Auth('sanctum')->user()->id;
        $cambioEstado->ud                     = Auth('sanctum')->user()->cod_ud;
        $cambioEstado->seccion_operador       = Auth('sanctum')->user()->cod_subud;

        $cambioEstado->save();

        return $cambioEstado;
    }

}
