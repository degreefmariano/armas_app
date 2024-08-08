<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auditorias\HistorialLoginAuditoriaRequest;
use Illuminate\Http\Request;
use App\Models\ArmaAuditoria;
use App\Models\HistorialLogin;
use App\Http\Requests\Auditorias\ValidaArmaAuditoriaRequest;
use App\Http\Resources\Auditoria\HistorialArmaCollectionResource;
use App\Http\Resources\Auditoria\HistorialLoginCollectionResource;

class AuditoriaController extends Controller
{
    public function getHistorialLogin(HistorialLoginAuditoriaRequest $request)
    { //dd($request);
        try {
            $resultados = new HistorialLoginCollectionResource(
                HistorialLogin::when(!is_null($request->fecha_desde), function ($query) use ($request) {
                    $desde = date('Y-m-d H:i:s', strtotime($request->input('fecha_desde') . ' 00:00:00'));
                    $hasta = date('Y-m-d H:i:s', strtotime($request->input('fecha_hasta') . ' 23:59:59'));
                    $query->whereBetween('fecha_hora_login', [$desde, $hasta]);
                })
                ->orderBy('fecha_hora_login', 'desc')
                ->paginate($request->offset ?? 5)
            );

            return api()->ok('Resultados', $resultados);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function getHistorialArma(ValidaArmaAuditoriaRequest $request)
    {
        try {
            $resultados = new HistorialArmaCollectionResource(
                ArmaAuditoria::when(!is_null($request->nro_arma), function ($query) use ($request) {
                    return $query->where('nro_arma', $request->nro_arma);
                })
                    ->orderBy('fecha', 'desc') 
                    ->orderBy('nro_ficha', 'desc') 
                    ->paginate($request->offset ?? 5)
            );

            return api()->ok('Resultados', $resultados);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }
    
}
