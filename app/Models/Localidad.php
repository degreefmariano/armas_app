<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Localidad extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;

    protected $table = 'localidad';
    protected $primaryKey = 'id_localidad';
    protected $connection = 'pgsql';
    
    protected $fillable = [
        'id_departamento',
        'nom_localidad'
    ];

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class, 'id_departamento');
    }

    public static function getLocalidad($id)
    {
        return Localidad::find($id);
    }

}
