<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MedidaCalibreArma extends Model
{
    use HasFactory;

    protected $table = 'medida_calibre';
    protected $primaryKey = 'id';
    protected $connection = 'pgsql';

    public function getMedidaCalibreArma()
    {
        return MedidaCalibreArma::select('id', 'descripcion')
            ->orderBy('descripcion')
            ->get();
        
    }

    public static function medidaCalibreArmaId($id)
    {
        return MedidaCalibreArma::select('id', 'descripcion')
            ->where('id', $id)
            ->first();
        
    }
}
