<?php

namespace App\Http\Requests\Arma;

use App\Rules\Arma\ArmaUpdateEstadoRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEstadoArmaRequest extends FormRequest
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
            'cod_estado' => ['required', Rule::exists('estado','cod_estado'), new ArmaUpdateEstadoRule($this->ficha)],
            'obs'        => ['nullable', 'string'] 
        ];
    }

    public function messages()
    {
        return [
            'cod_estado.required' => "Código de estado es obligatorio",
            'cod_estado.exists'   => "Código de estado no existe",
        ];
    }
}
