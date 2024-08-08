<?php

namespace App\Rules\Arma;

use App\Models\Arma;
use App\Models\SituacionArma;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;

class ArmaUpdateSituacionRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private $ficha, private $situacion, private $sub_situacion, private $ud)
    {
        //
    }

    public function passes($attribute, $value)
    {
        if ($this->situacion = SituacionArma::SEC_JUD) {
            return true;
        }

        $arma = DB::table('arma')
            ->where(['nro_ficha' => $this->ficha, 'situacion' => $this->situacion, 'sub_situacion' => $this->sub_situacion, 'ud_ar' => $this->ud])
            ->first();

        if ($arma) {
            return false;
        }
        return true;
    }

    public function message()
    {
        return 'AVISO...!!! no se realizo ningun cambio de situación';
    }
}
