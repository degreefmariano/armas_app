<?php

namespace App\Rules\Arma;

use App\Models\Arma;
use Illuminate\Contracts\Validation\Rule;

class CheckArmaMismaUnidadRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private $unidad, private $armas)
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
        $armas = Arma::whereIn('nro_ficha',$this->armas)
        ->where('ud_ar', $this->unidad)
        ->get();
            
        if ($armas->isNotEmpty()) {
            return false;
        }
        return true;
    }

    public function message()
    {
        return 'ERROR... las armas que está intentando entregar ya se encuentran en la misma UNIDAD';
    }
}
