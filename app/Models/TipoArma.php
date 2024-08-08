<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TipoArma extends Model
{
    use HasFactory;

    protected $table = 'tipo_arma';
    protected $primaryKey = 'id';
    protected $connection = 'pgsql';

    protected $fillable = [
        'descripcion',
        'updated_at',
        'deleted_at'
    ];

    public function getTiposArma()
    {
        return TipoArma::select('id', 'descripcion')
            ->whereNull('deleted_at')
            ->orderBy('descripcion')
            ->get();
        
    }

    public static function tipoArmaId($id)
    {
        return TipoArma::selectRaw('id, TRIM(descripcion) as descripcion')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
    }

    public function createTipoArma(Request $request)
    {
        $tipoArma = new TipoArma();
        $tipoArma->descripcion = $request->descripcion;
        $tipoArma->save();

        return $tipoArma;
    }

    public function updateTipoArma($tipoArmaId, Request $request)
    {
        $tipoArma = TipoArma::find($tipoArmaId);
        $tipoArma->descripcion = $request->descripcion;
        $tipoArma->update();

        return $tipoArma;
    }
}
