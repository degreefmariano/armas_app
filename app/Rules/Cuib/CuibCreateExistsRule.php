<?php

namespace App\Rules\Cuib;

use App\Models\CuibArma;
use Illuminate\Contracts\Validation\Rule;

class CuibCreateExistsRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private $ficha, private $sobre1, private $sobre2)
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
        $CuibArma = CuibArma::where(['nro_ficha' => $this->ficha, 'sobre1_cuib' => $this->sobre1, 'sobre2_cuib' => $this->sobre2])
            ->first();
        if ($CuibArma) {
            return false;
        }
        return true;
    }

    public function message()
    {
        return 'ERROR... ya existe el número de sobre para el arma';
    }
}
