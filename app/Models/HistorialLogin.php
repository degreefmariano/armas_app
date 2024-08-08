<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $cod_usr
 * @property timestamp $fecha_hora_login
 * @property timestamp $fecha_hora_logout
 * @property string $ip
 * @property string $name
 * @property string $email
 */
class HistorialLogin extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'historial_login';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = [
        'cod_usr',
        'fecha_hora_login',
        'fecha_hora_logout',
        'ip',
        'name',
        'email',
        'created_at',
        'updated_at'
    ];

}
