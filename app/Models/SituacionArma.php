<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SituacionArma extends Model
{
    use HasFactory;

    protected $table = 'situacion';
    protected $primaryKey = 'cod_situacion';
    protected $connection = 'pgsql';

    public const SITUACIONES = [
        SituacionArma::SERVICIO,
        SituacionArma::REPARACION,
        SituacionArma::DEPOSITO,
        SituacionArma::EXTRAVIADA,
        SituacionArma::SEC_JUD,
        SituacionArma::FUERA_SERVICIO,
        SituacionArma::BAJA,
        SituacionArma::SUSTRAIDA,
        SituacionArma::DEVOLUCION_UD_A_D4,
        SituacionArma::ALTA_EN_DEPOSITO,
        SituacionArma::REINGRESO,
    ];

    public const SERVICIO = 1;
    public const REPARACION = 2;
    public const DEPOSITO = 3;
    public const EXTRAVIADA = 4;
    public const SEC_JUD = 5;
    public const FUERA_SERVICIO = 6;
    public const BAJA = 7;
    public const SUSTRAIDA = 8;
    public const DEVOLUCION_UD_A_D4 = 9;
    public const ALTA_EN_DEPOSITO = 10;
    public const REINGRESO = 11;

    public function getSituacionesArma()
    {
        $situacionesExcluidas = [
            2,
            9,
            10,
            11,
        ];

        return SituacionArma::select('cod_situacion', 'nom_situacion')
            ->whereNotIn('cod_situacion', $situacionesExcluidas)
            ->orderBy('cod_situacion')
            ->get();
    }


    public static function situacionArmaId($id)
    {
        return SituacionArma::select('cod_situacion', 'nom_situacion')
            ->where('cod_situacion', $id)
            ->first();
    }

    public function createSituacionArma(Request $request)
    {
        $situacionArma = new SituacionArma();
        $situacionArma->nom_situacion = $request->nom_situacion;
        $situacionArma->save();

        return $situacionArma;
    }

    public function updateSituacionArma($situacionArmaId, Request $request)
    {
        $situacionArma = SituacionArma::find($situacionArmaId);
        $situacionArma->nom_situacion = $request->nom_situacion;
        $situacionArma->update();

        return $situacionArma;
    }
}
