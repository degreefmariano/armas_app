<?php

namespace App\Models;

use App\Repositories\PersonalRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PersonalArma extends Model
{
  use HasFactory;

  protected $table = 'personal_arma';
  protected $primaryKey = 'nro_ficha';
  protected $connection = 'pgsql';

  protected $fillable = [
    'legajo',
    'nro_arma',
    'cod_tipo_arma',
    'cod_marca',
    'cod_calibre_principal',
    'arma_corta_larga',
    'remarque',
    'cantidad_cargador',
    'cantidad_municion',
    'obs',
    'id_usr',
    'ud',
    'seccion_operador',
    'fecha_entrega',
    'created_at',
    'updated_at',
    'deleted_at'
  ];

  public function personal(): BelongsTo
  {
    return $this->belongsTo(Personal::class, 'legajo');
  }

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

  public function cortaLarga(): BelongsTo
  {
    return $this->belongsTo(CortaLargaArma::class, 'arma_corta_larga');
  }

  public static function asignarArmaPersonal(Request $request)
  {
    $arma = Arma::find($request->nro_ficha);

    $entrega = Entrega::newEntregaPersonal($request);

    if ($entrega) {
      DetalleEntrega::newDetalleEntregaPersonal($request, $entrega);

      $personalArma = new PersonalArma([
        'legajo'                => $request->legajo,
        'nro_arma'              => $arma->nro_arma,
        'cod_tipo_arma'         => $arma->cod_tipo_arma,
        'cod_marca'             => $arma->cod_marca,
        'cod_calibre_principal' => $arma->cod_calibre_principal,
        'arma_corta_larga'      => $arma->arma_corta_larga,
        'remarque'              => $arma->remarque,
        'cantidad_cargador'     => $request->cargadores,
        'cantidad_municion'     => $request->municiones,
        'obs'                   => $entrega->obs,
        'id_usr'                => $entrega->id_usr,
        'ud'                    => $entrega->ud_entrega,
        'seccion_operador'      => Auth('sanctum')->user()->cod_subud,
        'fecha_entrega'         => $request->fecha_entrega
      ]);
      $personalArma->save();

      $cambioSituacion = CambioSituacionArma::newCambioSituacionArmaEntregaPersonal($arma, $personalArma);
    }

    $arma->update([
      'situacion'     => $cambioSituacion->situacion,
      'sub_situacion' => null,
      'ud_ar'         => $entrega->ud_recibe,
      'subud_ar'      => $entrega->subud_recibe
    ]);
    return $arma;
  }

  public static function devolverArmaPersonal(Request $request)
  {
    $arma = Arma::find($request->nro_ficha);

    $personalArma = Arma::getPersonalArma($arma->nro_arma, $arma->cod_tipo_arma, $arma->cod_marca, $arma->cod_calibre_principal);

    if ($personalArma) {
      $okSaveHistorico = Arma::saveHistoricoPersonalArma($personalArma); //Se guarda el registro que se va a borrar de la tabla personal_arma

      if ($okSaveHistorico) {
        $personalArma->delete(); //Se borra el registro de la tabla personal_arma
      }
    }

    $devolucion = Devolucion::newDevolucionPersonal($request, $arma);

    if ($devolucion) {
      DetalleDevolucion::newDetalleDevolucionPersonal($request, $devolucion);
    }

    $cambioSituacion = CambioSituacionArma::newCambioSituacionArmaDevuelvePersonal($request, $arma);

    if (!is_null($request->estado)) {
      CambioEstadoArma::newCambioEstadoArmaDevuelvePersonal($request, $arma);
    }

    $arma->update([
      'situacion'     => $cambioSituacion->situacion,
      'sub_situacion' => Arma::SUBSITUACION_CREATE, //CONSULTAR
      'estado'        => !is_null($request->estado) ? $request->estado : $arma->estado,
      'ud_ar'         => Auth('sanctum')->user()->cod_ud,
      'subud_ar'      => Auth('sanctum')->user()->cod_subud
    ]);

    return $arma;
  }

  public static function getArmaActual($nlegajo_ps)
  {
    return PersonalArma::selectRaw('TRIM(nro_arma) as nro_arma,  TRIM(ta.descripcion) as tipo_arma, TRIM(ma.descripcion) as marca, TRIM(ca.descripcion) as calibre, TRIM(cl.descripcion) as corta_larga, fecha_entrega')
      ->join('tipo_arma as ta', 'personal_arma.cod_tipo_arma', '=', 'ta.id')
      ->join('marca_arma as ma', 'personal_arma.cod_marca', '=', 'ma.id')
      ->join('calibre as ca', 'personal_arma.cod_calibre_principal', '=', 'ca.id')
      ->join('corta_larga as cl', 'personal_arma.arma_corta_larga', '=', 'cl.id')
      ->where('legajo', $nlegajo_ps)
      ->first();
  }

  public static function getPersonalArmaAsignada($numero, $tipo, $marca, $calibre)
  {
    $legajo = PersonalArma::select('legajo')
      ->where([
        'nro_arma' => $numero,
        'cod_tipo_arma' => $tipo,
        'cod_marca' => $marca,
        'cod_calibre_principal' => $calibre
      ])
      ->first();

    if (!is_null($legajo)) {
      $funcionario = Personal::where('nlegajo_ps', $legajo->legajo)->first();
      if ($funcionario) {
        return Personal::selectRaw(DB::raw('TRIM(CONCAT_WS(" - ",nlegajo_ps,nombre_ps)) as funcionario'))->where('nlegajo_ps', $legajo->legajo)->first()->funcionario;
      } else {
        return null;
      }
    }
  }

  public static function devolucionEspecialArmaPersonal(Request $request)
  {
    $arma = Arma::find($request->nro_ficha);

    $personalArma = Arma::getPersonalArma($arma->nro_arma, $arma->cod_tipo_arma, $arma->cod_marca, $arma->cod_calibre_principal);

    if ($personalArma) {
      $okSaveHistorico = Arma::saveHistoricoPersonalArma($personalArma); //Se guarda el registro que se va a borrar de la tabla personal_arma

      if ($okSaveHistorico) {
        $personalArma->delete(); //Se borra el registro de la tabla personal_arma
      }
    }

    $cambioSituacion = CambioSituacionArma::newCambioSituacionArmaDevuelvePersonal($request, $arma);

    if (!is_null($request->estado)) {
      CambioEstadoArma::newCambioEstadoArmaDevuelvePersonal($request, $arma);
    }

    $arma->update([
      'situacion'     => $cambioSituacion->situacion,
      'sub_situacion' => Arma::SUBSITUACION_CREATE, //CONSULTAR
      'estado'        => !is_null($request->estado) ? $request->estado : $arma->estado,
      'ud_ar'         => $request->unidad,
      'subud_ar'      => $request->subunidad
    ]);

    return $arma;
  }

  public static function fechaEntrega($numero, $tipo, $marca, $calibre)
  {
    $fechaEntrega = PersonalArma::where([
        'nro_arma' => $numero,
        'cod_tipo_arma' => $tipo,
        'cod_marca' => $marca,
        'cod_calibre_principal' => $calibre
      ])
      ->orderBy('nro_ficha', 'DESC')
      ->first()->fecha_entrega;

    if (!is_null($fechaEntrega)) {
      return $fechaEntrega;
    }
  }
}
