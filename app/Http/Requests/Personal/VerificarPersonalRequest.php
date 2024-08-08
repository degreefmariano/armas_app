<?php

namespace App\Http\Requests\Personal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VerificarPersonalRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'legajo' => ['required', 'numeric', 'digits_between:6,7', Rule::exists('users', 'legajo')
            ],
        ];
    }

    public function messages()
    {
        return [
            'legajo.required'       => 'El legajo es obligatorio.',
            'legajo.numeric'        => 'El legajo debe ser numerico.',
            'legajo.digits_between' => 'El legajo debe tener entre 6 y 7 dígitos.',
            'legajo.exists'         => 'El legajo no existe en la base de datos.'
        ];
    }
}
