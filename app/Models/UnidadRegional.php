<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class UnidadRegional extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */


    protected $table = 'uregional';
    protected $primaryKey = 'cod_uregional';
    public $timestamps = false;

    protected $fillable = [
        'cod_uregional', 'nom_uregional'

    ];

}
