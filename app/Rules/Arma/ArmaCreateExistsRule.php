<?php

namespace App\Rules\Arma;

use App\Models\Arma;
use Illuminate\Contracts\Validation\Rule;

class ArmaCreateExistsRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private $nroArma, private $tipoArma, private $marcaArma, private $calibreArma)
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
        $arma = Arma::where(['nro_arma'=>$this->nroArma, 'cod_tipo_arma'=>$this->tipoArma, 'cod_marca'=>$this->marcaArma, 'cod_calibre_principal'=>$this->calibreArma])
            ->first();
       
        if ($arma) {
            return false;
        }
        return true;
    }

    public function message()
    {
        return 'ERROR... ya existe un arma con el mismo número, tipo, marca y calibre';
    }
}
