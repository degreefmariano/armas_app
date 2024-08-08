<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UsoArma extends Model
{
    use HasFactory;

    protected $table = 'uso_arma';
    protected $primaryKey = 'id';
    protected $connection = 'pgsql';

    public function getUsosArma()
    {
        return UsoArma::select('id', 'descripcion')
            ->orderBy('descripcion')
            ->get();
        
    }

    public static function usoArmaId($id)
    {
        return UsoArma::select('id', 'descripcion')
            ->where('id', $id)
            ->first();
        
    }
}
