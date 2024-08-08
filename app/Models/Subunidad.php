<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Subunidad extends Model
{
    use HasFactory;

    protected $table = 'subunidades';
    protected $primaryKey = 'cod_subud';
    protected $connection = 'pgsql';

    protected $casts = [
        'cod_subud' => 'string',
    ];

    protected $fillable = [
        'nom_subud',
        'ud_subud'
    ];

    public static function getSubunidadArmaAsignada($subud)
    {
        $subunidad = Subunidad::select('nom_subud')
        ->where([
            'cod_subud' => $subud,
        ])
        ->first();

        if (!is_null($subunidad)) {
            return trim($subunidad->nom_subud);
        }
    }

    public static function getSubunidadUser($cod_subud)
    {
        $subunidad = Subunidad::select('nom_subud')
        ->where([
            'cod_subud' => $cod_subud,
        ])
        ->first();

        if (!is_null($subunidad)) {
            return trim($subunidad->nom_subud);
        }
    }

    public static function subunidadId($id)
    { 
        return Subunidad::where('cod_subud',$id)->first()->nom_subud;
    }

}
