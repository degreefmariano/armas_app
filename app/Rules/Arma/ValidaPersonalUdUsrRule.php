<?php

namespace App\Rules\Arma;

use App\Models\Arma;
use App\Models\PersonalArma;
use App\Models\Personal;
use Illuminate\Contracts\Validation\Rule;

class ValidaPersonalUdUsrRule implements Rule
{
    protected $legajo;

    public function __construct($legajo)
    {
        $this->legajo = $legajo;
    }

    public function passes($attribute, $value)
    {
        $personalArma = PersonalArma::where('legajo', $this->legajo)->first();

        if (auth('sanctum')->user()->cod_ud == Arma::UD_AR) {
            $personal = Personal::where('nlegajo_ps', $this->legajo)->first();
        } else {
            $personal = Personal::where('nlegajo_ps', $this->legajo)
                ->where('ud_ps', auth('sanctum')->user()->cod_ud)
                ->first();
        }

        return !($personalArma || is_null($personal));
    }

    public function message()
    {
        $personalArma = PersonalArma::where('legajo', $this->legajo)->first();

        if (auth('sanctum')->user()->cod_ud == Arma::UD_AR) {
            $personal = Personal::where('nlegajo_ps', $this->legajo)->first();
        } else {
            $personal = Personal::where('nlegajo_ps', $this->legajo)
                ->where('ud_ps', auth('sanctum')->user()->cod_ud)
                ->first();
        }

        if (is_null($personal)) {
            return 'ERROR... El legajo ' . $this->legajo . ' no corresponde a su unidad.';
        }

        if ($personalArma) {
            return 'ERROR... El legajo ' . $this->legajo . ' ya posee un arma asignada.';
        }
    }
}