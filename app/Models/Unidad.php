<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Unidad extends Model
{
    use HasFactory;

    protected $table = 'unidades';
    protected $primaryKey = 'cod_ud';
    protected $connection = 'pgsql';

    protected $fillable = [
        'nom_ud'
    ];

    public static function unidadId($id)
    { 
        return Unidad::where('cod_ud',$id)->first()->nom_ud;
    }

    public function subunidad(): BelongsTo
    {
        return $this->belongsTo(Subunidad::class, 'cod_ud');
    }

}
