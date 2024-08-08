<?php

namespace App\Http\Requests\Arma;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArmaRequest extends FormRequest
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
            'nro_ficha' => ['required', Rule::exists('arma','nro_ficha')],
        ];
    }

    public function messages()
    {
        return [
            'nro_ficha.required' => "El nro de ficha es obligatorio",
            'nro_ficha.exists'   => "El nro de ficha no existe",
        ];
    }
}
