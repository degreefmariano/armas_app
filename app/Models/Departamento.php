<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Departamento extends Authenticatable
{
    use Notifiable;
    // use SoftDeletes;
    use HasApiTokens;

    protected $table = 'departamento';
    protected $primaryKey = 'id_departamento';
    protected $connection = 'pgsql';
    
    protected $fillable = [
        'nom_departamento'
    ];


}
