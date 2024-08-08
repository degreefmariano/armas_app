<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ControlPersonalPDFRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'legajo' => [
                'required',
                'numeric',
                Rule::exists('users', 'legajo'),
                'digits_between:6,7',
            ],
        ];
    }

    public function messages()
    {
        return [
            'legajo.required' => 'El legajo es obligatorio.',
            'legajo.numeric' => 'El legajo debe ser numerico.',
            'legajo.digits_between' => 'El legajo debe tener entre 6 y 7 digitos.',
            'legajo.exists' => 'El legajo no existe en la base de datos.'
        ];
    }
}
