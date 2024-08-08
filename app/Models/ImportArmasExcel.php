<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ImportArmasExcel extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';
    protected $table = 'import_armas_excel';
    protected $fillable = ['serie', 'tipo', 'marca', 'calibre', 'modelo'];
    public $timestamps = false;

}
