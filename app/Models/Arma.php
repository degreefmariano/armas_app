<?php

namespace App\Models;

use App\Repositories\PersonalRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Arma extends Model
{
    use HasFactory;

    protected $table = 'arma';
    protected $primaryKey = 'nro_ficha';
    protected $connection = 'pgsql';

    public const COD_LEGAJO = 4;
    public const NRO_LEGAJO = 9342000;
    public const DEPOSITO = 3;
    public const SERVICIO = 1;
    public const UD_AR = 24;
    public const SITUACION_CREATE = 3;
    public const SITUACION_SERVICIO = 1;
    public const SUBSITUACION_CREATE = 1;
    public const ESTADO_CREATE = 1;
    public const DEVOLUCION_UD_D4 = 9;
    public const ALTA_EN_DEPOSITO = 10;
    public const ARMA_CORTA = 1;
    public const ARMA_LARGA = 2;

    protected $fillable = [
        'fecha_alta',
        'cod_legajo',
        'legajo',
        'cod_tipo',
        'modelo',
        'nro_arma',
        'cod_tipo_arma',
        'cod_marca',
        'cod_calibre_principal',
        'arma_corta_larga',
        'remarque',
        'medida_calibre_principal',
        'calibre_secundario',
        'medida_calibre_sec',
        'largo_canon_principal',
        'largo_canon_secundario',
        'clasificacion',
        'situacion',
        'obs',
        'id_usr',
        'ud',
        'seccion_operador',
        'fecha_hora_carga',
        'ud_ar',
        'ud_ar1',
        'estado',
        'created_at',
        'updated_at',
        'deleted_at',
        'subud_ar',
        'sub_situacion'
    ];

    public function tipo(): BelongsTo
    {
        return $this->belongsTo(TipoArma::class, 'cod_tipo_arma');
    }

    public function marca(): BelongsTo
    {
        return $this->belongsTo(MarcaArma::class, 'cod_marca');
    }

    public function calibre(): BelongsTo
    {
        return $this->belongsTo(CalibreArma::class, 'cod_calibre_principal');
    }

    public function medidaCalibre(): BelongsTo
    {
        return $this->belongsTo(MedidaCalibreArma::class, 'medida_calibre_principal');
    }

    public function estadoArma(): BelongsTo
    {
        return $this->belongsTo(EstadoArma::class, 'estado');
    }

    public function situacionArma(): BelongsTo
    {
        return $this->belongsTo(SituacionArma::class, 'situacion');
    }

    public function cortaLarga(): BelongsTo
    {
        return $this->belongsTo(CortaLargaArma::class, 'arma_corta_larga');
    }

    public function usoArma(): BelongsTo
    {
        return $this->belongsTo(UsoArma::class, 'clasificacion');
    }

    public function unidad(): BelongsTo
    {
        return $this->belongsTo(Unidad::class, 'ud_ar');
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
        $arma->sub_situacion            = Arma::SUBSITUACION_CREATE; //CONSULTAR
        $arma->ud_ar                    = Arma::UD_AR;
        $arma->fecha_alta               = $request->fecha_alta;
        $arma->id_usr                   = Auth('sanctum')->user()->id;
        $arma->ud                       = Auth('sanctum')->user()->cod_ud;
        $arma->seccion_operador         = Auth('sanctum')->user()->cod_subud;
        $arma->save();

        ArmaAuditoria::newArmaAuditoria($arma);
        CambioSituacionArma::newArmaEnDeposito($arma);
        CambioEstadoArma::newArmaAltaEnDeposito($arma);

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
        $arma->id_usr                   = Auth('sanctum')->user()->id;
        $arma->ud                       = Auth('sanctum')->user()->cod_ud;
        $arma->seccion_operador         = Auth('sanctum')->user()->cod_subud;
        $arma->estado                   = $request->cod_estado;
        $arma->update();

        return $arma;
    }

    public function updateEstadoArma($ficha, Request $request)
    {
        $arma = Arma::find($ficha);

        $cambioEstado = new CambioEstadoArma();
        $cambioEstado->estado                = $request->cod_estado;
        $cambioEstado->nro_arma              = $arma->nro_arma;
        $cambioEstado->cod_tipo_arma         = $arma->cod_tipo_arma;
        $cambioEstado->cod_marca             = $arma->cod_marca;
        $cambioEstado->cod_calibre_principal = $arma->cod_calibre_principal;
        $cambioEstado->fecha_movimiento      = Carbon::now()->format('Y-m-d');
        $cambioEstado->obs                   = $request->obs;
        $cambioEstado->id_usr                = Auth('sanctum')->user()->id;
        $cambioEstado->ud                    = Auth('sanctum')->user()->cod_ud;
        $cambioEstado->seccion_operador      = Auth('sanctum')->user()->cod_subud;
        $cambioEstado->save();

        $arma->estado = $request->cod_estado;
        $arma->update();

        return $arma;
    }

    public function updateSituacionArma($ficha, Request $request)
    {
        $arma = Arma::find($ficha);

        if ($arma->situacion == SituacionArma::SERVICIO) {
            $personalArma = $this->getPersonalArma($arma->nro_arma, $arma->cod_tipo_arma, $arma->cod_marca, $arma->cod_calibre_principal);

            if ($personalArma) {
                $okSaveHistorico = $this->saveHistoricoPersonalArma($personalArma); //Se guarda el registro que se va a borrar de la tabla personal_arma

                if ($okSaveHistorico) {
                    $personalArma->delete(); //Se borra el registro de la tabla personal_arma
                }
            }
        }

        $cambioSituacion = new CambioSituacionArma();
        $cambioSituacion->situacion              = $request->situacion;
        $cambioSituacion->nro_arma               = $arma->nro_arma;
        $cambioSituacion->cod_tipo_arma          = $arma->cod_tipo_arma;
        $cambioSituacion->cod_marca              = $arma->cod_marca;
        $cambioSituacion->calibre_principal      = $arma->cod_calibre_principal;
        $cambioSituacion->fecha_movimiento       = $request->fecha_movimiento;
        $cambioSituacion->obs                    = $request->obs;
        $cambioSituacion->id_usr                 = Auth('sanctum')->user()->id;
        $cambioSituacion->ud                     = Auth('sanctum')->user()->cod_ud;
        $cambioSituacion->seccion_operador       = Auth('sanctum')->user()->cod_subud;
        $cambioSituacion->trabajo_realizado      = $request->trabajo_realizado;
        $cambioSituacion->fecha_hecho            = $request->fecha_hecho;
        $cambioSituacion->lugar_hecho            = $request->lugar_hecho;
        $cambioSituacion->dep_interviniente      = $request->dep_interviniente;
        $cambioSituacion->fiscalia_interviniente = $request->fiscalia_interviniente;
        $cambioSituacion->victimas               = $request->victimas;
        $cambioSituacion->imputados              = $request->imputados;
        $cambioSituacion->caratula               = $request->caratula;
        $cambioSituacion->lugar_deposito         = $request->lugar_deposito;
        $cambioSituacion->sub_situacion          = $request->sub_situacion;
        $cambioSituacion->cuij                   = $request->cuij;
        $cambioSituacion->save();

        $arma->situacion     = $request->situacion;
        $arma->sub_situacion = $request->sub_situacion;
        $arma->ud_ar         = $request->cod_ud;
        $arma->update();

        return $arma;
    }

    public static function getPersonalArma($nro_arma, $tipo_arma, $marca, $calibre)
    {
        return PersonalArma::where([
            'nro_arma' => $nro_arma,
            'cod_tipo_arma' => $tipo_arma,
            'cod_marca' => $marca,
            'cod_calibre_principal' => $calibre
        ])
            ->first();
    }

    public static function saveHistoricoPersonalArma($personalArma)
    {
        $personal = trim(PersonalRepository::getPersonalArma($personalArma->nro_arma, $personalArma->cod_tipo_arma, $personalArma->cod_marca, $personalArma->cod_calibre_principal)->funcionario);
        $unidad = PersonalRepository::getPersonalUdArma($personalArma->nro_arma, $personalArma->cod_tipo_arma, $personalArma->cod_marca, $personalArma->cod_calibre_principal);
        (!is_null($personalArma->obs) or !empty($personalArma->obs)) ?
            $obs = $personalArma->obs . '. ' . "El arma se encontraba asignada al funcionario: " . $personal . ". Destinado en: " . $unidad->cod_ud . ' - ' . $unidad->nom_ud :
            $obs = "El arma se encontraba asignada al funcionario: " . $personal . ". Destinado en: " . $unidad->cod_ud . ' - ' . $unidad->nom_ud;

        $historico = new Historico();
        $historico->legajo                = $personalArma->legajo;
        $historico->nro_arma              = $personalArma->nro_arma;
        $historico->cod_tipo_arma         = $personalArma->cod_tipo_arma;
        $historico->cod_marca             = $personalArma->cod_marca;
        $historico->cod_calibre_principal = $personalArma->cod_calibre_principal;
        $historico->arma_corta_larga      = $personalArma->arma_corta_larga;
        $historico->remarque              = $personalArma->remarque;
        $historico->cantidad_cargador     = $personalArma->cantidad_cargador;
        $historico->cantidad_municion     = $personalArma->cantidad_municion;
        $historico->obs                   = $obs;
        $historico->id_usr                = $personalArma->id_usr;
        $historico->ud                    = $personalArma->ud;
        $historico->seccion_operador      = $personalArma->seccion_operador;
        $historico->fecha_entrega         = $personalArma->fecha_entrega;
        $historico->fecha_hora_carga      = $personalArma->fecha_hora_carga;
        $historico->save();

        return $historico;
    }

    public function getHistorialArma(Request $request)
    {
        return Arma::find($request->nro_ficha);
    }

    public function getArmasDepositoPorUd(Request $request)
    {
        $cortaLarga = $request->corta_larga;
        $userCodUd = Auth('sanctum')->user()->cod_ud;
        $searchTerm = $request->input('search');

        $query = Arma::join('tipo_arma', 'arma.cod_tipo_arma', '=', 'tipo_arma.id')
            ->join('marca_arma', 'arma.cod_marca', '=', 'marca_arma.id')
            ->join('calibre', 'arma.cod_calibre_principal', '=', 'calibre.id')
            ->join('estado', 'arma.estado', '=', 'estado.cod_estado')
            ->where('arma.ud_ar', $userCodUd)
            ->where('arma.situacion', Arma::DEPOSITO)
            // ->where('arma.sub_situacion', Arma::SUBSITUACION_CREATE)
            ->where('arma.arma_corta_larga', $cortaLarga);

        if ($searchTerm) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('arma.nro_arma', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('arma.nro_ficha', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('tipo_arma.descripcion', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('marca_arma.descripcion', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('calibre.descripcion', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('arma.modelo', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('estado.nom_estado', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        return $query->orderBy('arma.nro_arma')
            ->paginate($request->offset ?? 5);
    }

    public static function getArmaAsignada($nro_arma, $tipo_arma, $marca, $calibre)
    {
        return Arma::select(
            'nro_ficha',
            'nro_arma',
            DB::raw('TRIM(tipo_arma.descripcion) as tipo'),
            DB::raw('TRIM(marca_arma.descripcion) as marca'),
            DB::raw('TRIM(calibre.descripcion) as calibre'),
            'arma.estado as cod_estado',
            'estado.nom_estado as estado',
            'situacion.nom_situacion as situacion'
        )
            ->join('tipo_arma', function ($join) {
                $join->on('arma.cod_tipo_arma', '=', 'tipo_arma.id');
            })
            ->join('marca_arma', function ($join) {
                $join->on('arma.cod_marca', '=', 'marca_arma.id');
            })
            ->join('calibre', function ($join) {
                $join->on('arma.cod_calibre_principal', '=', 'calibre.id');
            })
            ->join('estado', function ($join) {
                $join->on('arma.estado', '=', 'estado.cod_estado');
            })
            ->join('situacion', function ($join) {
                $join->on('arma.situacion', '=', 'situacion.cod_situacion');
            })
            ->where([
                'nro_arma' => $nro_arma,
                'cod_tipo_arma' => $tipo_arma,
                'cod_marca' => $marca,
                'cod_calibre_principal' => $calibre
            ])
            ->first();
    }

    public function getArmasUdDevuelve(Request $request)
    {
        $cortaLarga = $request->corta_larga;
        $unidad = $request->unidad;
        $subunidad = $request->subunidad;
        $search = $request->search;

        $query = Arma::join('tipo_arma', 'arma.cod_tipo_arma', '=', 'tipo_arma.id')
            ->join('marca_arma', 'arma.cod_marca', '=', 'marca_arma.id')
            ->join('calibre', 'arma.cod_calibre_principal', '=', 'calibre.id')
            ->join('estado', 'arma.estado', '=', 'estado.cod_estado')
            ->where('arma.ud_ar', $unidad)
            ->where('arma.subud_ar', $subunidad)
            ->where('arma.situacion', Arma::DEPOSITO)
            // ->where('arma.sub_situacion', Arma::SUBSITUACION_CREATE)
            ->where('arma.arma_corta_larga', $cortaLarga);

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('arma.nro_arma', 'LIKE',  "%$search%" )
                    ->orWhere('arma.nro_ficha', 'LIKE', "%$search%")
                    ->orWhere('tipo_arma.descripcion', 'LIKE', "%$search%")
                    ->orWhere('marca_arma.descripcion', 'LIKE', "%$search%")
                    ->orWhere('calibre.descripcion', 'LIKE', "%$search%")
                    ->orWhere('arma.modelo', 'LIKE', "%$search%")
                    ->orWhere('estado.nom_estado', 'LIKE',"%$search%");
            });

        }
        return $query->orderBy('arma.nro_arma')
            ->paginate($request->offset ?? 5);
    }

    public function getArmasDependenciaAUdDevuelve(Request $request)
    {
        $subunidad = $request->subunidad;
        $search = $request->search;
        $query = Arma::join('tipo_arma', 'arma.cod_tipo_arma', '=', 'tipo_arma.id')
            ->join('marca_arma', 'arma.cod_marca', '=', 'marca_arma.id')
            ->join('calibre', 'arma.cod_calibre_principal', '=', 'calibre.id')
            ->join('estado', 'arma.estado', '=', 'estado.cod_estado')
            ->where('arma.situacion', Arma::SERVICIO)
            ->where('arma_corta_larga', CortaLargaArma::LARGA)
            ->where('arma.ud_ar', Auth('sanctum')->user()->cod_ud)
            ->where('arma.subud_ar', $subunidad);

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('arma.nro_arma', 'LIKE',  "%$search%" )
                    ->orWhere('arma.nro_ficha', 'LIKE', "%$search%")
                    ->orWhere('tipo_arma.descripcion', 'LIKE', "%$search%")
                    ->orWhere('marca_arma.descripcion', 'LIKE', "%$search%")
                    ->orWhere('calibre.descripcion', 'LIKE', "%$search%")
                    ->orWhere('arma.modelo', 'LIKE', "%$search%")
                    ->orWhere('estado.nom_estado', 'LIKE',"%$search%");
            });
        }
            return $query->orderBy('nro_ficha', 'desc')
            ->paginate($request->offset ?? 5);
    }

}
