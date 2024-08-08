<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CuibArma extends Model
{
    use HasFactory;

    protected $table = 'cuib_arma';
    protected $primaryKey = 'id';
    protected $connection = 'pgsql';

    protected $fillable = [
        'nro_ficha',
        'sobre1_cuib',
        'sobre2_cuib',
        'caja_cuib',
        'fecha_cuib',
        'id_usr',
        'created_at',
        'updated_at',
        'deleted_at'
        
    ];

    public function getCuibsArma(Request $request)
    {
        return CuibArma::where('nro_ficha', $request->nro_ficha)->whereNull('deleted_at')->get();
    }

    public static function cuibsArmaId($ficha)
{
    $cuibs = CuibArma::select('sobre1_cuib','sobre2_cuib','caja_cuib','fecha_cuib')
        ->where('nro_ficha', $ficha)
        ->whereNull('deleted_at')
        ->orderBy('fecha_cuib','DESC')
        ->get();

    foreach ($cuibs as $cuib) {
        $cuib->fecha_cuib = date('d-m-Y', strtotime($cuib->fecha_cuib));
    }

    return $cuibs;
}


    public function createCuibArma(Request $request)
    { 
        $cuibArma = new CuibArma();
        $cuibArma->nro_ficha   = $request->nro_ficha;
        $cuibArma->sobre1_cuib = $request->sobre1_cuib;
        $cuibArma->sobre2_cuib = $request->sobre2_cuib;
        $cuibArma->caja_cuib   = $request->caja_cuib;
        $cuibArma->fecha_cuib  = $request->fecha_cuib;
        $cuibArma->id_usr      = Auth('sanctum')->user()->id;
        $cuibArma->save();

        return $cuibArma;       
    }
}
