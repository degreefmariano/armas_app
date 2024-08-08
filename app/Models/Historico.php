<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Historico extends Model
{
  use HasFactory;

  protected $table = 'historico';
  protected $primaryKey = 'nro_ficha';
  protected $connection = 'pgsql';

  public static function getArmaHistorico($nlegajo_ps)
  {
    return Historico::selectRaw('TRIM(nro_arma) as nro_arma, TRIM(ta.descripcion) as tipo_arma, TRIM(ma.descripcion) as marca, TRIM(ca.descripcion) as calibre, TRIM(cl.descripcion) as corta_larga, fecha_entrega')
      ->join('tipo_arma as ta', 'historico.cod_tipo_arma', '=', 'ta.id')
      ->join('marca_arma as ma', 'historico.cod_marca', '=', 'ma.id')
      ->join('calibre as ca', 'historico.cod_calibre_principal', '=', 'ca.id')
      ->join('corta_larga as cl', 'historico.arma_corta_larga', '=', 'cl.id')
      ->where('legajo', $nlegajo_ps)
      ->get();
  }
}
