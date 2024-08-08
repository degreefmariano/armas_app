<?php

namespace App\Http\Requests\Personal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PersonalHistorialNombreRequest extends FormRequest
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
            'nombre_ps' => ['required', 'min:4'],
        ];
    }

    public function messages()
    {
        return [
            'nombre_ps.required' => "El nombre es obligatorio",
            'nombre_ps.min'      => "Debe ingresar al menos 4 caracteres",
        ];
    }
}
