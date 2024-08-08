<?php

namespace App\Rules\Arma;

use App\Models\Arma;
use Illuminate\Contracts\Validation\Rule;

class CheckArmaEnDepositoRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private $nroFicha)
    {
        //
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function passes($attribute, $value)
    {
        $arma = Arma::where('nro_ficha',$this->nroFicha)
            ->where('situacion','=', Arma::DEPOSITO)
            // ->where('sub_situacion','=',Arma::SUBSITUACION_CREATE) //CONSULTAR
            ->first();
        if ($arma) {
            return true;
        }
        return false;
    }

    public function message()
    {
        return 'El arma que está intentando entregar no se encuentra en RESERVA ESTRATEGICA';
    }
}
