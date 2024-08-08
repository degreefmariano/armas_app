<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $table = 'personal';
    protected $primaryKey = 'nlegajo_ps';
    protected $connection = 'pgsql';

    public const PERSONAL_ACTIVO = 1;
    public const PERSONAL_INACTIVO = 2;

    public $incrementing = false;

    protected $fillable = [
        'nombre_ps',
        'cuil_ps',
        'desc_ps',
        'nom_sestados',
        'ud_ps',
        'nom_ud',
        'subud_ps',
        'nom_subud',
        'srevista_ps',
        'ndoc_ps',
        'nom_gr',
        'fec_alta_ps',
        'fec_baja_ps',
        'fec_nac_ps',
        'sexo_ps',
        'cpoesc_ps',
        'sestado_ps',
        'grado_ps'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unidad()
    {
        return $this->belongsTo('App\Models\Unidad', 'ud_ps', 'cod_ud');
    }

    public function subunidad()
    {
        return $this->belongsTo('App\Models\Subunidad', 'subud_ps', 'cod_subud');
    }

    public function grado()
    {
        return $this->belongsTo('app\Grado', 'grado_ps', 'cod_gr');
    }
    public function getEntregas()
    {
        return $this->hasMany('App\Models\Entrega', 'legajo', 'nlegajo_ps');
    }

    public static function getPersonalArmaAsignada($legajo)
    {
        $query = Personal::select('nlegajo_ps', 'nombre_ps')->where('nlegajo_ps', $legajo)->first();
        $personal = trim($query->nlegajo_ps).' - '.trim($query->nombre_ps);
        return $personal;
    }
}
