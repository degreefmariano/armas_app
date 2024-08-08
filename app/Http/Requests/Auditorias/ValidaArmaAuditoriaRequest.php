<?php

namespace App\Http\Requests\Auditorias;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidaArmaAuditoriaRequest extends FormRequest
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
            'nro_arma' => ['nullable', Rule::exists('arma','nro_arma')],
        ];
    }

    public function messages()
    {
        return [
            'nro_arma.exists'   => "El nro de arma no existe",
        ];
    }
}
