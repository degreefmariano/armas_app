<?php

namespace App\Rules\Arma;

use App\Models\Arma;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;

class CheckSituacionServicioRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private $ficha)
    {
        //
    }

    public function passes($attribute, $value)
    { 
        $ficha = $this->ficha;
        $arma = DB::table('arma')
            ->where('nro_ficha', $ficha)
            ->first();

        if ($arma->situacion == Arma::SERVICIO AND $value == Arma::DEPOSITO) {
            return false;
        }
        return true;
    }

    public function message()
    {
        return 'ERROR...!!! el arma se encuentra en servicio, no se podra pasar a deposito sin realizar previamente la devolución de la misma';
    }
}
