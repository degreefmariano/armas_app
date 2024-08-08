<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VistaPersonalArma extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'vista_personal_arma';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
  //  protected $primaryKey = 'nlegajo_ps';

  protected $connection = 'pgsql';
    protected $primaryKey = 'nlegajo_ps';

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
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
  
}
