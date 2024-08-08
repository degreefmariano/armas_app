<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class EstadoArma extends Model
{
    use HasFactory;

    protected $table = 'estado';
    protected $primaryKey = 'cod_estado';
    protected $connection = 'pgsql';

    protected $fillable = [
        'nom_estado',
        
    ];

    public function getEstadosArma()
    {
        return EstadoArma::select('cod_estado', 'nom_estado')
            ->orderBy('cod_estado')
            ->get();
        
    }

    public function createEstadoArma(Request $request)
    { 
        $estadoArma = new EstadoArma();
        $estadoArma->nom_estado = $request->nom_estado;
        $estadoArma->save();

        return $estadoArma;       
    }

    public function updateEstadoArma($estadoArmaId, Request $request)
    { 
        $estadoArma = EstadoArma::find($estadoArmaId);
        $estadoArma->nom_estado = $request->nom_estado;
        $estadoArma->update();

        return $estadoArma;
    }

    public static function estadoArmaId($id)
    {
        return EstadoArma::select('cod_estado', 'nom_estado')
            ->where('cod_estado', $id)
            ->first();
        
    }
}
