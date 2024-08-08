<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SubSituacionArma extends Model
{
    use HasFactory;

    protected $table = 'subsituacion';
    protected $primaryKey = 'id';
    protected $connection = 'pgsql';

    public const SUBSITUACION_REPARACION = 6;

    public function getSubSituacionesArma(Request $request)
    {
        return SubSituacionArma::select('id', 'descripcion')
            ->where('id_situacion',$request->cod_situacion)
            ->orderBy('id')
            ->get();
    }

    public static function subSituacionArmaId($id)
    {
        return SubSituacionArma::where('id',$id)->first()->id;
    }

    public static function subSituacionArmaDesc($id)
    {
        return SubSituacionArma::where('id',$id)->first()->descripcion;
    }
}
