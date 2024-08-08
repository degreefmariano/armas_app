<?php

namespace App\Rules\Arma;

use App\Models\Arma;
use App\Models\Personal;
use Illuminate\Contracts\Validation\Rule;

class ValidaPersonalArmaUnidadRule implements Rule
{
    public function __construct(private $legajo)
    {
        //
    }

    public function passes($attribute, $value)
    {
        if (Auth('sanctum')->user()->cod_ud == Arma::UD_AR) {
            $personal = Personal::where('nlegajo_ps', $this->legajo)->first();
        } else {
            $personal = Personal::where('nlegajo_ps', $this->legajo)
                ->where('ud_ps', Auth('sanctum')->user()->cod_ud)
                ->first();
        }

        if (is_null($personal)) {
            return false;
        }
        return true;
    }

    public function message()
    {
        return 'El legajo '.$this->legajo.' ingresado no corresponde a su unidad';
    }
}
