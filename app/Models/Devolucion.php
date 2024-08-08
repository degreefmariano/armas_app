<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Personal;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Devolucion extends Model
{
    use HasFactory;

    protected $table = 'devolucion';
    protected $primaryKey = 'id';
    protected $connection = 'pgsql';

    public const DEVOLUCION_PERSONAL = 1;
    public const DEVOLUCION_MASIVA = 2;

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usr');
    }

    public function udEntrega(): BelongsTo
    {
        return $this->belongsTo(Unidad::class, 'ud_entrega');
    }

    public function personal(): BelongsTo
    {
        return $this->belongsTo(Personal::class, 'legajo_devuelve');
    }
    
    public function udRecibe(): BelongsTo
    {
        return $this->belongsTo(Unidad::class, 'ud_recibe');
    }

    public function subUdRecibe(): BelongsTo
    {
        return $this->belongsTo(Subunidad::class, 'subud_recibe');
    }

    public function localidadRecibe(): BelongsTo
    {
        return $this->belongsTo(Localidad::class, 'localidad_recibe');
    }

    public function subUdAnterior(): BelongsTo
    {
        return $this->belongsTo(Subunidad::class, 'subud_arma_anterior');
    }

    public function UdAnterior(): BelongsTo
    {
        return $this->belongsTo(Unidad::class, 'ud_arma_anterior');
    }

    public static function newDevolucionPersonal(Request $request, $arma)
    {
        $nota = Devolucion::select(DB::raw('max(nro_nota + 1) as nota'))->where('ud_recibe',Auth('sanctum')->user()->cod_ud)->first();

        $devolucion = new Devolucion();
        $devolucion->nro_nota = is_null($nota->nota) ? 1 : $nota->nota;
        $devolucion->tipo = Devolucion::DEVOLUCION_PERSONAL;
        $devolucion->legajo_devuelve = $request->legajo;
        $devolucion->ud_recibe = Auth('sanctum')->user()->cod_ud;
        $devolucion->localidad_recibe = Auth('sanctum')->user()->id_localidad;
        $devolucion->ud_arma_anterior = $arma->ud_ar;
        $devolucion->subud_arma_anterior = $arma->subud_ar;
        $devolucion->fecha_devolucion = Carbon::now()->format('Y-m-d');
        $devolucion->obs = $request->obs;
        $devolucion->id_usr = Auth('sanctum')->user()->id;
        $devolucion->cargadores = $request->cargadores;
        $devolucion->municiones = $request->municiones;
        $devolucion->save();
        
        return $devolucion;
    }

    public function devolverArmasMasiva(Request $request)
    {
        $arrayArmas = $request->armas;
        $armas = Arma::whereIn('nro_ficha',$arrayArmas)->get();

        $devolucion = Devolucion::newDevolucionMasiva($request);
        if ($devolucion) {
            DetalleDevolucion::newDetalleDevolucionMasiva($arrayArmas, $devolucion);
        }

        foreach ($armas as $arma)
        { 
            
            CambioSituacionArma::newCambioSituacionArmaDevuelve($request, $arma);
            $arma->update([ 
                'situacion'=> Arma::DEPOSITO,
                'ud_ar'    => Auth('sanctum')->user()->cod_ud,
                'subud_ar' => Auth('sanctum')->user()->cod_subud
            ]);
        }
        
        return $armas;
    }

    public static function newDevolucionMasiva(Request $request)
    {
        $nota = Devolucion::select(DB::raw('max(nro_nota + 1) as nota'))->where('ud_recibe',Auth('sanctum')->user()->cod_ud)->first();

        $devolucion = new Devolucion();
        $devolucion->nro_nota = is_null($nota->nota) ? 1 : $nota->nota;
        $devolucion->tipo = Devolucion::DEVOLUCION_MASIVA;
        $devolucion->legajo_devuelve = $request->legajo;
        $devolucion->ud_recibe = Auth('sanctum')->user()->cod_ud;
        $devolucion->localidad_recibe = Auth('sanctum')->user()->id_localidad;
        $devolucion->ud_arma_anterior = $request->unidad;
        $devolucion->subud_arma_anterior = $request->subunidad;
        $devolucion->fecha_devolucion = Carbon::now()->format('Y-m-d');
        $devolucion->obs = $request->obs;
        $devolucion->id_usr = Auth('sanctum')->user()->id;
        $devolucion->save();

        return $devolucion;
    }

    public static function getDevolucionArmaTipo(Request $request)
    {
        $tipo = $request->tipo_devolucion;
        return Devolucion::when(!is_null($request->fecha_desde), function ($query) use ($request) {
                return $query->whereBetween('fecha_devolucion', [$request->fecha_desde, $request->fecha_hasta]);
            })
            ->when(!is_null($request->personal_devuelve), function ($query) use ($request) {
                return $query->where('legajo_devuelve', $request->personal_devuelve);
            })
            ->when(!is_null($request->ud_recibe), function ($query) use ($request) {
                return $query->where('ud_recibe', $request->ud_recibe);
            })
            ->when(!is_null($request->ud_arma_anterior), function ($query) use ($request) {
                return $query->where('ud_arma_anterior', $request->ud_arma_anterior);
            })
            ->when(!is_null($request->subud_arma_anterior), function ($query) use ($request) {
                return $query->where('subud_arma_anterior', $request->subud_arma_anterior);
            })
            ->where('ud_recibe', Auth('sanctum')->user()->cod_ud)
            ->where('tipo', $tipo)
            ->orderBy('id', 'desc')
            ->paginate($request->offset ?? 5);
    }

}
