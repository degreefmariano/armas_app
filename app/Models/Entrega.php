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
use GuzzleHttp\Psr7\Query;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entrega extends Model
{
    use HasFactory;

    protected $table = 'entrega';
    protected $primaryKey = 'id';
    protected $connection = 'pgsql';

    public const ENTREGA_PERSONAL = 1;
    public const ENTREGA_MASIVA = 2;

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
        return $this->belongsTo(Personal::class, 'legajo_personal');
    }

    public function udRecibe(): BelongsTo
    {
        return $this->belongsTo(Unidad::class, 'ud_recibe');
    }

    public function subUdRecibe(): BelongsTo
    {
        return $this->belongsTo(Subunidad::class, 'subud_recibe');
    }

    public function localidadEntrega(): BelongsTo
    {
        return $this->belongsTo(Localidad::class, 'localidad_entrega');
    }

    public static function newEntregaPersonal(Request $request)
    {
        $nota = Entrega::select(DB::raw('max(nro_nota + 1) as nota'))->where('ud_entrega', Auth('sanctum')->user()->cod_ud)->first();
        $personalRecibe = Personal::select('ud_ps', 'subud_ps')->where('nlegajo_ps', $request->legajo)->first();

        $entrega = new Entrega();
        $entrega->nro_nota = is_null($nota->nota) ? 1 : $nota->nota;
        $entrega->tipo = Entrega::ENTREGA_PERSONAL;
        $entrega->legajo_personal = $request->legajo;
        $entrega->ud_entrega = Auth('sanctum')->user()->cod_ud;
        $entrega->localidad_entrega = Auth('sanctum')->user()->id_localidad;
        $entrega->ud_recibe = $personalRecibe->ud_ps;
        $entrega->subud_recibe = $personalRecibe->subud_ps;
        $entrega->fecha_entrega = $request->fecha_entrega;
        $entrega->obs = $request->obs;
        $entrega->id_usr = Auth('sanctum')->user()->id;
        $entrega->save();

        return $entrega;
    }

    public static function getEntregaArmaTipo(Request $request)
    {
            $tipo = $request->tipo_entrega;
            
            $entrega = Entrega::select(
                     'entrega.id',
                     'entrega.nro_nota',
                     'entrega.fecha_entrega',
                     'entrega.tipo',
                     'entrega.legajo_personal',
                     'entrega.obs',
                     'personal.nombre_ps as personal_nombre',
                     'unidades.nom_ud as udRecibe_nombre',
                     'subunidades.nom_subud as subUdRecibe_nombre',
                     'users.name as usuario_nombre',
                )
                ->leftJoin('unidades', function ($join) {
                    $join->on('unidades.cod_ud', '=', 'entrega.ud_recibe');
                })
                ->leftJoin('subunidades', function ($join) {
                    $join->on('subunidades.cod_subud', '=', 'entrega.subud_recibe');
                })
                ->leftJoin('personal', function ($join) {
                    $join->on('personal.nlegajo_ps', '=', 'entrega.legajo_personal');
                })
                ->leftJoin('users', function ($join) {
                    $join->on('users.id', '=', 'entrega.id_usr');
                })
                ->when(!is_null($request->fecha_desde), function ($query) use ($request) {
                    return $query->whereBetween('fecha_entrega', [$request->fecha_desde, $request->fecha_hasta]);
                })
                ->when(!is_null($request->legajo), function ($query) use ($request) {
                    return $query->where('legajo_personal', $request->legajo);
                })
                ->when(!is_null($request->ud_recibe), function ($query) use ($request) {
                    return $query->where('ud_recibe', $request->ud_recibe);
                })
                ->when(!is_null($request->subud_recibe), function ($query) use ($request) {
                    return $query->where(DB::raw('CAST(entrega.subud_recibe AS TEXT)'), $request->subud_recibe);
                })
                ->where('ud_entrega', Auth('sanctum')->user()->cod_ud)
                ->where('tipo', $tipo)
                ->orderBy('entrega.id', 'desc')
                ->paginate($request->offset ?? 5);

                return $entrega;
    }

    public function asignarArmaMasiva(Request $request)
    {
        $armas = Arma::whereIn('nro_ficha', $request->armas)->get();
        $nota = Entrega::select(DB::raw('max(nro_nota + 1) as nota'))->where('ud_entrega', Auth('sanctum')->user()->cod_ud)->first();

        $entrega = new Entrega();
        $entrega->nro_nota = is_null($nota->nota) ? 1 : $nota->nota;
        $entrega->tipo = Entrega::ENTREGA_MASIVA;
        $entrega->legajo_personal = $request->legajo;
        $entrega->ud_entrega = Auth('sanctum')->user()->cod_ud;
        $entrega->localidad_entrega = Auth('sanctum')->user()->id_localidad;
        $entrega->ud_recibe = $request->unidad;
        $entrega->subud_recibe = $request->subunidad;
        $entrega->fecha_entrega = Carbon::now()->format('Y-m-d');
        $entrega->obs = $request->obs;
        $entrega->id_usr = Auth('sanctum')->user()->id;
        $entrega->save();

        if ($entrega) {
            DetalleEntrega::newDetalleEntregaMasiva($request, $entrega->id);
        }

        foreach ($armas as $arma) {
            $arma->update([
                'ud_ar'    => $request->unidad,
                'subud_ar' => $request->subunidad
            ]);
        }

        return $armas;
    }

    public function asignarArmaMasivaLargas(Request $request)
    {
        $armas = Arma::whereIn('nro_ficha', $request->armas)->get();
        $nota = Entrega::select(DB::raw('max(nro_nota + 1) as nota'))->where('ud_entrega', Auth('sanctum')->user()->cod_ud)->first();

        $entrega = new Entrega();
        $entrega->nro_nota = is_null($nota->nota) ? 1 : $nota->nota;
        $entrega->tipo = Entrega::ENTREGA_MASIVA;
        $entrega->legajo_personal = $request->legajo;
        $entrega->ud_entrega = Auth('sanctum')->user()->cod_ud;
        $entrega->localidad_entrega = Auth('sanctum')->user()->id_localidad;
        $entrega->ud_recibe = $request->unidad;
        $entrega->subud_recibe = $request->subunidad;
        $entrega->fecha_entrega = Carbon::now()->format('Y-m-d');
        $entrega->obs = $request->obs;
        $entrega->id_usr = Auth('sanctum')->user()->id;
        $entrega->save();

        if ($entrega) {
            DetalleEntrega::newDetalleEntregaMasiva($request, $entrega->id);
        }

        foreach ($armas as $arma) {
            $arma->update([
                'subud_ar'  => $request->subunidad,
                'situacion' => Auth('sanctum')->user()->cod_ud <> Arma::UD_AR ? Arma::SERVICIO : $arma->situacion
            ]);
        }

        return $entrega;
    }
}
