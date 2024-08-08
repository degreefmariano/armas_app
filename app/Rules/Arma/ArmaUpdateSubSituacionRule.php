<?php

namespace App\Rules\Arma;

use App\Models\SituacionArma;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;

class ArmaUpdateSubSituacionRule implements Rule
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
            ->where(['nro_ficha' => $ficha, 'sub_situacion' => $value])
            ->first();

        if ($arma) {
            return false;
        }
        return true;
    }

    public function message()
    {
        return 'AVISO...!!! no se realizo ningun cambio de sub situación';
    }
}
