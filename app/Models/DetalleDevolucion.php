<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DetalleDevolucion extends Model
{
    use HasFactory;

    protected $table = 'detalle_devolucion';
    protected $primaryKey = 'id_detalle_devolucion';
    protected $connection = 'pgsql';

    public static function newDetalleDevolucionPersonal(Request $request, $devolucion)
    {
        $detalleDevolucion = new DetalleDevolucion();
        $detalleDevolucion->id_devolucion = $devolucion->id;
        $detalleDevolucion->nro_ficha = $request->nro_ficha;
        $detalleDevolucion->save();
    }

    public static function newDetalleDevolucionMasiva($arrayArmas, $devolucion)
    {
        foreach ($arrayArmas as $arma) {
            $detalleDevolucion = new DetalleDevolucion();
            $detalleDevolucion->id_devolucion = $devolucion->id;
            $detalleDevolucion->nro_ficha = $arma;
            $detalleDevolucion->save();
        }
    }
}
