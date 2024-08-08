<?php

namespace App\Rules\Arma;

use App\Models\Arma;
use App\Models\CortaLargaArma;
use Illuminate\Contracts\Validation\Rule;

class CheckArmaMismaDependenciaRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private $subunidad, private $armas)
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
    public $errorType;

    public function passes($attribute, $value)
    {
        $armasLargas = Arma::whereIn('nro_ficha', $this->armas)
            ->where('arma_corta_larga', CortaLargaArma::LARGA)
            ->get();

        if ($armasLargas->isEmpty()) {
            $this->errorType = 'armasLargas';
            return false;
        }

        $armasEnDependencia = Arma::whereIn('nro_ficha', $this->armas)
            ->where('subud_ar', $this->subunidad)
            ->get();

        if ($armasEnDependencia->isNotEmpty()) {
            $this->errorType = 'armasEnDependencia';
            return false;
        }
        
        return true;
    }

    public function message()
    {
        if ($this->errorType === 'armasLargas') {
            return 'ERROR... solo se pueden hacer entregas de armas LARGAS';
        } elseif ($this->errorType === 'armasEnDependencia') {
            return 'ERROR... las armas que está intentando entregar ya se encuentran en la misma DEPENDENCIA';
        }
    }

}
