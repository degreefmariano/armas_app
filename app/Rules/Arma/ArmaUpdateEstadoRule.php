<?php

namespace App\Rules\Arma;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;

class ArmaUpdateEstadoRule implements Rule
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
            ->where(['nro_ficha' => $ficha, 'estado' => $value])
            ->first();

        if ($arma) {
            return false;
        }
        return true;
    }

    public function message()
    {
        return 'AVISO...!!! no se realizo ningun cambio de estado';
    }
}
