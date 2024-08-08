<?php

namespace App\Http\Requests\Password;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlanquearPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
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
            'legajo.required'       => 'El legajo es obligatorio.',
            'legajo.numeric'        => 'El legajo debe ser numerico.',
            'legajo.digits_between' => 'El legajo debe estar entre 6 y 7 dígitos.',
            'legajo.exists'         => 'El legajo no existe en la base de datos.'
        ];
    }

}
