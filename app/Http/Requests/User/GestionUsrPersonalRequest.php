<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GestionUsrPersonalRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nlegajo_ps' => ['required', 'numeric', 'digits_between:5,8', Rule::exists('personal','nlegajo_ps')]
        ];
    }

    public function messages()
    {
        return [
            'nlegajo_ps.required'       => "El nro de legajo es obligatorio",
            'nlegajo_ps.numeric'        => "Debe ingresar solo números",
            'nlegajo_ps.digits_between' => "El nro de legajo debe estar comprendido entre 5 y 8 dígitos..",
            'nlegajo_ps.exists'         => "El nro de legajo no existe",
        ];
    }
}
