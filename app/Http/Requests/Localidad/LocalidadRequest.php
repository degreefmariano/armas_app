<?php

namespace App\Http\Requests\Localidad;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LocalidadRequest extends FormRequest
{
    protected $stopOnFirstFailure = false;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'id' => ['required', Rule::exists('departamento', 'id_departamento')],
            ];
    }

    public function messages()
    {
        return [
            'id.required' => 'El departamento es obligatorio.',
            'id.exists'   => 'El departamento no existe.',
        ];
    }
}
