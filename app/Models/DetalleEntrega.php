<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DetalleEntrega extends Model
{
    use HasFactory;

    protected $table = 'detalle_entrega';
    protected $primaryKey = 'id_detalle_entrega';
    protected $connection = 'pgsql';

    public static function newDetalleEntregaPersonal(Request $request, $entrega)
    {
        $detalleEntrega = new DetalleEntrega();
        $detalleEntrega->id_entrega = $entrega->id;
        $detalleEntrega->nro_ficha = $request->nro_ficha;
        $detalleEntrega->save();

        return $detalleEntrega;
    }

    public static function newDetalleEntregaMasiva(Request $request, $idEntrega)
    {
        foreach ($request->armas as $arma) {
          
            $detalleEntrega = new DetalleEntrega();
            $detalleEntrega->id_entrega = $idEntrega;
            $detalleEntrega->nro_ficha = $arma;
            $detalleEntrega->save();
        }
    }
}
