<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MarcaArma extends Model
{
    use HasFactory;

    protected $table = 'marca_arma';
    protected $primaryKey = 'id';
    protected $connection = 'pgsql';

    public function getMarcasArma()
    {
        return MarcaArma::select('id', 'descripcion')
            ->whereNull('deleted_at')
            ->orderBy('descripcion')
            ->get();
        
    }

    public static function marcaArmaId($id)
    {
        return MarcaArma::selectRaw('id, TRIM(descripcion) as descripcion')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
    }

    public function createMarcaArma(Request $request)
    {
        $marcaArma = new MarcaArma();
        $marcaArma->descripcion = $request->descripcion;
        $marcaArma->save();

        return $marcaArma;       
    }

    public function updateMarcaArma($marcaArmaId, Request $request)
    { 
        $marcaArma = MarcaArma::find($marcaArmaId);
        $marcaArma->descripcion = $request->descripcion;
        $marcaArma->update();

        return $marcaArma;
    }
}
