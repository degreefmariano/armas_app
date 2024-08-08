<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Seccional extends Model
{
    //use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'seccional';
    public $timestamps = false;
    protected $primaryKey = 'cod_seccional';
    protected $keyType = 'string';

    /**
     * The primary key for the model.
     *
     * @var string
     */


    /**
     * @var array
     */
    protected $fillable = ['nombre','ud_subud','cod_seccional'];




}
