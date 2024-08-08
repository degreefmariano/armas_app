<?php

namespace App\Http\Requests\Personal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ConsultaPersonalRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nlegajo_ps' => ['required', 'numeric', 'digits_between:6,7', Rule::exists('users', 'legajo')],
        ];
    }

    public function messages()
    {
        return [
            'nlegajo_ps.required'       => 'El legajo es obligatorio.',
            'nlegajo_ps.numeric'        => 'El legajo debe ser numerico.',
            'nlegajo_ps.digits_between' => 'El legajo debe tener entre 6 y 7 dígitos.',
            'nlegajo_ps.exists'         => 'El legajo no existe en la base de datos.'
        ];
    }
}
