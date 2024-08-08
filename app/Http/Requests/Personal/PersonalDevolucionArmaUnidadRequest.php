<?php

namespace App\Http\Requests\Personal;

use App\Rules\Arma\ValidaPersonalArmaUnidadRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PersonalDevolucionArmaUnidadRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nlegajo_ps' => [new ValidaPersonalArmaUnidadRule($this['nlegajo_ps']), 
        ],
        ];
    }
}
