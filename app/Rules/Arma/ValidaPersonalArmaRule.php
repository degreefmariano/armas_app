<?php

namespace App\Rules\Arma;

use App\Models\PersonalArma;
use Illuminate\Contracts\Validation\Rule;

class ValidaPersonalArmaRule implements Rule
{
    public function __construct(private $legajo)
    {
        //
    }

    public function passes($attribute, $value)
    {
        $personalArma = PersonalArma::where('legajo', $this->legajo)->first();

        if (is_null($personalArma)) {
            return false;
        }
        return true;
    }

    public function message()
    {
        return 'El legajo '.$this->legajo.' ingresado no posee armas asignadas';
    }
}
