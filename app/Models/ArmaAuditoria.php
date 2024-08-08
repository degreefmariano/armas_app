<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $cod_usr
 * @property timestamp $fecha_hora_login
 * @property timestamp $fecha_hora_logout
 * @property string $ip
 * @property string $name
 * @property string $email
 */
class ArmaAuditoria extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'arma_auditoria';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    // protected $primaryKey = 'nro_ficha';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = [
        'nro_ficha',
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
        'sub_situacion',
        'fecha',
        'hora',
        'usr_modifico_reg'
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

    public function cortaLarga(): BelongsTo
    {
        return $this->belongsTo(CortaLargaArma::class, 'arma_corta_larga');
    }

    public function situacionArma(): BelongsTo
    {
        return $this->belongsTo(SituacionArma::class, 'situacion');
    }

    public function subSituacionArma(): BelongsTo
    {
        return $this->belongsTo(SubSituacionArma::class, 'sub_situacion');
    }

    public function unidad(): BelongsTo
    {
        return $this->belongsTo(Unidad::class, 'ud_ar');
    }

    public function estadoArma(): BelongsTo
    {
        return $this->belongsTo(EstadoArma::class, 'estado');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usr_modifico_reg');
    }

    public function usr_ud(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usr_modifico_reg');
    }

    public function usr_subud(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usr_modifico_reg');
    }

    public static function newArmaAuditoria($arma)
    {
        $armaAud = new ArmaAuditoria();
        $armaAud->nro_ficha                = $arma->nro_ficha;
        $armaAud->fecha_alta               = $arma->fecha_alta;
        $armaAud->cod_legajo               = $arma->cod_legajo;
        $armaAud->legajo                   = $arma->legajo;
        $armaAud->modelo                   = $arma->modelo;
        $armaAud->nro_arma                 = $arma->nro_arma;
        $armaAud->cod_tipo_arma            = $arma->cod_tipo_arma;
        $armaAud->cod_marca                = $arma->cod_marca;
        $armaAud->cod_calibre_principal    = $arma->cod_calibre_principal;
        $armaAud->arma_corta_larga         = $arma->arma_corta_larga;
        $armaAud->medida_calibre_principal = $arma->medida_calibre_principal;
        $armaAud->largo_canon_principal    = $arma->largo_canon_principal;
        $armaAud->clasificacion            = $arma->clasificacion;
        $armaAud->situacion                = $arma->situacion;
        $armaAud->sub_situacion            = $arma->sub_situacion;
        $armaAud->obs                      = $arma->obs;
        $armaAud->id_usr                   = $arma->id_usr;
        $armaAud->ud                       = $arma->ud;
        $armaAud->ud_ar                    = $arma->ud_ar;
        $armaAud->seccion_operador         = $arma->seccion_operador;
        $armaAud->estado                   = $arma->estado;
        $armaAud->fecha                    = Carbon::now()->format('Y-m-d');
        $armaAud->hora                     = Carbon::now()->format('H:i:s');
        $armaAud->usr_modifico_reg         = $arma->id_usr;
        
        $armaAud->save();

        return $armaAud;
    }

}
