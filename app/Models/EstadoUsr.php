<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class EstadoUsr extends Authenticatable
{
    use Notifiable;
    // use SoftDeletes;
    use HasApiTokens;

    protected $table = 'estados_usr';
    protected $primaryKey = 'id';
    protected $connection = 'pgsql';
    
    protected $fillable = [
        'nombre'
    ];

    public function User()
    {
        return $this->hasMany(User::class, 'id');
    }

    public static function getEstadoUsr($id){
        return EstadoUsr::find($id);
    }

}
