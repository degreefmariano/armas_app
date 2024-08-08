<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CalibreArma extends Model
{
    use HasFactory;

    protected $table = 'calibre';
    protected $primaryKey = 'id';
    protected $connection = 'pgsql';

    public function getCalibresArma()
    {
        return CalibreArma::select('id', 'descripcion')
            ->whereNull('deleted_at')
            ->orderBy('descripcion')
            ->get();
        
    }

    public static function calibreArmaId($id)
    {
        return CalibreArma::selectRaw('id, TRIM(descripcion) as descripcion')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
        
    }

    public function createCalibreArma(Request $request)
    { 
        $calibreArma = new CalibreArma();
        $calibreArma->descripcion = $request->descripcion;
        $calibreArma->save();

        return $calibreArma;       
    }

    public function updateCalibreArma($calibreArmaId, Request $request)
    { 
        $calibreArma = CalibreArma::find($calibreArmaId);
        $calibreArma->descripcion = $request->descripcion;
        $calibreArma->update();

        return $calibreArma;
    }
}
