<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
class VistaArma extends Model
{
    use HasFactory;

    protected $table = 'vista_arma';
    protected $connection = 'pgsql';

    public function unidad(): BelongsTo
    {
        return $this->belongsTo(Unidad::class, 'ud_ar');
    }

    public function subUnidad(): BelongsTo
    {
        return $this->belongsTo(Subunidad::class, 'subud_ar');
    }

    public function personal(): BelongsTo
    {
        return $this->belongsTo(Personal::class, 'personal_legajo');
    }

    public function getArmasFiltros(Request $request)
    {
        return VistaArma::when(!is_null($request->search), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('nro_arma', 'LIKE', "%$search%")
                    ->orWhere('nom_tipo_arma', 'LIKE', "%$search%")
                    ->orWhere('nom_marca_arma', 'LIKE', "%$search%")
                    ->orWhere('nom_cal_principal', 'LIKE', "%$search%")
                    ->orWhere('nom_estado', 'LIKE', "%$search%")
                    ->orWhere('nom_situacion', 'LIKE', "%$search%")
                    ->orWhere('descripcion', 'LIKE', "%$search%")
                    ->orWhere('corta_larga', 'LIKE', "%$search%");
                    });
                })
                ->when(!is_null($request->nro_arma), function ($query) use ($request) {
                    return $query->where('nro_arma', $request->nro_arma);
                })
                ->when(!is_null($request->cod_tipo_arma), function ($query) use ($request) {
                    return $query->where('cod_tipo_arma', $request->cod_tipo_arma);
                })
                ->when(!is_null($request->cod_marca), function ($query) use ($request) {
                    return $query->where('cod_marca', $request->cod_marca);
                })
                ->when(!is_null($request->cod_calibre_principal), function ($query) use ($request) {
                    return $query->where('cod_calibre_principal', $request->cod_calibre_principal);
                })
                ->when(!is_null($request->estado), function ($query) use ($request) {
                    return $query->where('estado', $request->estado);
                })
                ->when(!is_null($request->situacion), function ($query) use ($request) {
                    return $query->where('situacion', $request->situacion);
                })
                ->when(!is_null($request->subsituacion), function ($query) use ($request) {
                    return $query->where('sub_situacion', $request->subsituacion);
                })
                ->when(!is_null($request->arma_corta_larga), function ($query) use ($request) {
                    return $query->where('arma_corta_larga', $request->arma_corta_larga);
                })
                ->when(!is_null($request->ud_ar), function ($query) use ($request) {
                    return $query->where('ud_ar', $request->ud_ar);
                })
                ->when(!is_null($request->subud_ar), function ($query) use ($request) {
                    return $query->where('subud_ar', $request->subud_ar);
                })
                ->orderBy('nro_ficha', 'desc')->paginate($request->offset ?? 5);
    }

    public function getArmaClave(Request $request)
    {
        return VistaArma::when(!is_null($request->search), function ($query) use ($request) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nro_ficha', 'LIKE', "%$search%")
                ->orWhere('fecha_alta', 'LIKE', "%$search%")
                ->orWhere('modelo', 'LIKE', "%$search%")
                ->orWhere('nro_arma', 'LIKE', "%$search%")
                ->orWhere('nom_tipo_arma', 'LIKE', "%$search%")
                ->orWhere('nom_marca_arma', 'LIKE', "%$search%")
                ->orWhere('nom_cal_principal', 'LIKE', "%$search%")
                ->orWhere('corta_larga', 'LIKE', "%$search%")
                ->orWhere('nom_medida_cal_ppal', 'LIKE', "%$search%")
                ->orWhere('uso', 'LIKE', "%$search%")
                // ->orWhere('asignada', 'LIKE', "%$search%")
                ->orWhere('nom_situacion', 'LIKE', "%$search%")
                ->orWhere('ud_ar', 'LIKE', "%$search%")
                ->orWhere('subud_ar', 'LIKE', "%$search%")
                ->orWhere('nom_estado', 'LIKE', "%$search%")
                /* ->orWhere('nom_subsituacion', 'LIKE', "%$search%") hay que agregar nom_subsituacion en la vista */
                ->orWhere('nom_estado', 'LIKE', "%$search%");
                });
            })
            ->with(['unidad','subUnidad'])
            ->when(!is_null($request->nro_ficha), function ($query) use ($request) {
                return $query->where('nro_ficha', $request->nro_ficha);
            })
            ->when(!is_null($request->fecha_alta), function ($query) use ($request) {
                return $query->where('fecha_alta', $request->fecha_alta);
            })
            ->when(!is_null($request->modelo), function ($query) use ($request) {
                return $query->where('modelo', $request->modelo);
            })
            ->when(!is_null($request->nro_arma), function ($query) use ($request) {
                return $query->where('nro_arma', $request->nro_arma);
            })
            ->when(!is_null($request->cod_tipo_arma), function ($query) use ($request) {
                return $query->where('cod_tipo_arma', $request->cod_tipo_arma);
            })
            ->when(!is_null($request->cod_marca), function ($query) use ($request) {
                return $query->where('cod_marca', $request->cod_marca);
            })
            ->when(!is_null($request->cod_calibre_principal), function ($query) use ($request) {
                return $query->where('cod_calibre_principal', $request->cod_calibre_principal);
            })
            ->when(!is_null($request->arma_corta_larga), function ($query) use ($request) {
                return $query->where('arma_corta_larga', $request->arma_corta_larga);
            })
            ->when(!is_null($request->medida_calibre_principal), function ($query) use ($request) {
                return $query->where('medida_calibre_principal', $request->medida_calibre_principal);
            })
            ->when(!is_null($request->clasificacion), function ($query) use ($request) {
                return $query->where('clasificacion', $request->clasificacion);
            })
            ->when(!is_null($request->situacion), function ($query) use ($request) {
                return $query->where('situacion', $request->situacion);
            })
            ->when(!is_null($request->asignada), function ($query) use ($request) {
                return $query->where('asignada', $request->asignada);
            })
            ->when(!is_null($request->subsituacion), function ($query) use ($request) {
                return $query->where('sub_situacion', $request->subsituacion);
            })
            ->when(!is_null($request->ud_ar), function ($query) use ($request) {
                return $query->where('ud_ar', $request->ud_ar);
            })
            ->when(!is_null($request->subud_ar), function ($query) use ($request) {
                return $query->where('subud_ar', $request->subud_ar);
            })
            ->when(!is_null($request->estado), function ($query) use ($request) {
                return $query->where('estado', $request->estado);
            })
            ->orderBy('nro_ficha', 'desc')->paginate($request->offset ?? 5);
    }

    public static function getArmaClaveAsignar(Request $request)
    {
        $userCodUd = Auth('sanctum')->user()->cod_ud;
        return VistaArma::when(!is_null($request->search), function ($query) use ($request) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nro_ficha', 'LIKE', "%$search%")
                ->orWhere('fecha_alta', 'LIKE', "%$search%")
                ->orWhere('modelo', 'LIKE', "%$search%")
                ->orWhere('nro_arma', 'LIKE', "%$search%")
                ->orWhere('nom_tipo_arma', 'LIKE', "%$search%")
                ->orWhere('nom_marca_arma', 'LIKE', "%$search%")
                ->orWhere('nom_cal_principal', 'LIKE', "%$search%")
                ->orWhere('corta_larga', 'LIKE', "%$search%")
                ->orWhere('nom_medida_cal_ppal', 'LIKE', "%$search%")
                ->orWhere('uso', 'LIKE', "%$search%")
                // ->orWhere('asignada', 'LIKE', "%$search%")
                ->orWhere('nom_situacion', 'LIKE', "%$search%")
                ->orWhere('ud_ar', 'LIKE', "%$search%")
                ->orWhere('subud_ar', 'LIKE', "%$search%")
                ->orWhere('nom_estado', 'LIKE', "%$search%")
                ->orWhere('descripcion', 'LIKE', "%$search%") 
                ->orWhere('nom_estado', 'LIKE', "%$search%");
                });
            })
            ->with(['unidad','subUnidad'])
            ->when(!is_null($request->nro_ficha), function ($query) use ($request) {
                return $query->where('nro_ficha', $request->nro_ficha);
            })
            ->when(!is_null($request->fecha_alta), function ($query) use ($request) {
                return $query->where('fecha_alta', $request->fecha_alta);
            })
            ->when(!is_null($request->modelo), function ($query) use ($request) {
                return $query->where('modelo', $request->modelo);
            })
            ->when(!is_null($request->nro_arma), function ($query) use ($request) {
                return $query->where('nro_arma', $request->nro_arma);
            })
            ->when(!is_null($request->cod_tipo_arma), function ($query) use ($request) {
                return $query->where('cod_tipo_arma', $request->cod_tipo_arma);
            })
            ->when(!is_null($request->cod_marca), function ($query) use ($request) {
                return $query->where('cod_marca', $request->cod_marca);
            })
            ->when(!is_null($request->cod_calibre_principal), function ($query) use ($request) {
                return $query->where('cod_calibre_principal', $request->cod_calibre_principal);
            })
            ->when(!is_null($request->arma_corta_larga), function ($query) use ($request) {
                return $query->where('arma_corta_larga', $request->arma_corta_larga);
            })
            ->when(!is_null($request->medida_calibre_principal), function ($query) use ($request) {
                return $query->where('medida_calibre_principal', $request->medida_calibre_principal);
            })
            ->when(!is_null($request->clasificacion), function ($query) use ($request) {
                return $query->where('clasificacion', $request->clasificacion);
            })
            ->when(!is_null($request->situacion), function ($query) use ($request) {
                return $query->where('situacion', $request->situacion);
            })
            ->when(!is_null($request->asignada), function ($query) use ($request) {
                return $query->where('asignada', $request->asignada);
            })
            ->when(!is_null($request->subsituacion), function ($query) use ($request) {
                return $query->where('sub_situacion', $request->subsituacion);
            })
            ->when(!is_null($request->ud_ar), function ($query) use ($request) {
                return $query->where('ud_ar', $request->ud_ar);
            })
            ->when(!is_null($request->subud_ar), function ($query) use ($request) {
                return $query->where('subud_ar', $request->subud_ar);
            })
            ->when(!is_null($request->estado), function ($query) use ($request) {
                return $query->where('estado', $request->estado);
            })
            ->where('ud_ar', $userCodUd)
            ->where('arma_corta_larga', CortaLargaArma::CORTA)
            ->orderBy('nro_ficha', 'desc')->paginate($request->offset ?? 5);
    }

    public function getArma(Request $request)
    {
        return Arma::find($request->nro_ficha);
    }

    public function createArma(Request $request)
    {
        $arma = new Arma();
        $arma->nro_arma                 = $request->nro_arma;
        $arma->cod_tipo_arma            = $request->cod_tipo_arma;
        $arma->cod_marca                = $request->cod_marca;
        $arma->cod_calibre_principal    = $request->cod_calibre_principal;
        $arma->modelo                   = $request->modelo;
        $arma->medida_calibre_principal = $request->medida_calibre_principal;
        $arma->largo_canon_principal    = $request->largo_canon_principal;
        $arma->arma_corta_larga         = $request->arma_corta_larga;
        $arma->estado                   = $request->estado;
        $arma->clasificacion            = $request->clasificacion;
        $arma->obs                      = $request->obs;
        $arma->cod_legajo               = Arma::COD_LEGAJO;
        $arma->legajo                   = Arma::NRO_LEGAJO;
        $arma->situacion                = Arma::SITUACION_CREATE;
        $arma->ud_ar                    = Arma::UD_AR;
        $arma->fecha_alta               = Carbon::now()->format('Y-m-d');
        $arma->save();

        return $arma;
    }

    public function updateArma($ficha, Request $request)
    {
        $arma = Arma::find($ficha);

        $arma->cod_tipo_arma            = $request->cod_tipo_arma;
        $arma->cod_marca                = $request->cod_marca;
        $arma->cod_calibre_principal    = $request->cod_calibre_principal;
        $arma->modelo                   = $request->modelo;
        $arma->medida_calibre_principal = $request->medida_calibre_principal;
        $arma->largo_canon_principal    = $request->largo_canon_principal;
        $arma->arma_corta_larga         = $request->arma_corta_larga;
        $arma->clasificacion            = $request->clasificacion;
        $arma->fecha_alta               = $request->fecha_alta;
        $arma->obs                      = $request->obs;
        $arma->update();

        return $arma;
    }

    public function updateEstadoArma($ficha, Request $request)
    {
        $arma = Arma::find($ficha);

        $arma->estado = $request->cod_estado;
        $arma->update();

        return $arma;
    }

    public function updateSituacionArma($ficha, Request $request)
    {
        $arma = Arma::find($ficha);

        $arma->situacion = $request->cod_situacion;
        $arma->update();

        return $arma;
    }

    public function traeDatosArma($nro_arma, $cod_tipo_arma, $cod_marca, $calibre_principal)
    {
        return VistaArma::where([
            'nro_arma' => $nro_arma,
            'cod_tipo_arma' => $cod_tipo_arma,
            'cod_marca' => $cod_marca,
            'cod_calibre_principal' => $calibre_principal
            ])
            ->orderBy('nro_ficha', 'DESC')
            ->first();
    }    
}
