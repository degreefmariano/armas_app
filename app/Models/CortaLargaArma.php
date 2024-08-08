<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CortaLargaArma extends Model
{
    use HasFactory;

    protected $table = 'corta_larga';
    protected $primaryKey = 'id';
    protected $connection = 'pgsql';

    public const CORTA_LARGA = [
        CortaLargaArma::CORTA,
        CortaLargaArma::LARGA,
    ];

    public const CORTA = 1;
    public const LARGA = 2;

    public function getCortaLargaArma()
    {
        return CortaLargaArma::select('id', 'descripcion')
            ->orderBy('descripcion')
            ->get();
        
    }

    public static function cortaLargaArmaId($id)
    {
        return CortaLargaArma::select('id', 'descripcion')
            ->where('id', $id)
            ->first();
        
    }
}
