<?php

namespace App\Rules\Arma;

use App\Models\Arma;
use Illuminate\Contracts\Validation\Rule;

class CheckArmaEnServicioRule implements Rule
{
    public function __construct(private $nroFicha)
    {
        //
    }

    public function passes($attribute, $value)
    {
        $arma = Arma::where('nro_ficha',$this->nroFicha)
            ->where('situacion','=', Arma::SERVICIO)
            ->first();
        if ($arma) {
            return true;
        }
        return false;
    }

    public function message()
    {
        return 'ERROR... el arma que está intentando devolver no se encuentra en SERVICIO';
    }
}
