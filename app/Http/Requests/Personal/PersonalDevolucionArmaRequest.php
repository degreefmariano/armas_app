<?php

namespace App\Http\Requests\Personal;

use App\Rules\Arma\ValidaPersonalArmaRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PersonalDevolucionArmaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nlegajo_ps' => [new ValidaPersonalArmaRule($this['nlegajo_ps'])],
        ];
    }
    
}
