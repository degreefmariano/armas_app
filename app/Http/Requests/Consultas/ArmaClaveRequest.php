<?php

namespace App\Http\Requests\Consultas;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArmaClaveRequest extends FormRequest
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
            'nro_arma'  => ['nullable', 'min:3'],
            'situacion' => ['nullable', Rule::exists('situacion','cod_situacion')]
        ];
    }

    public function messages()
    {
        return [
            // 'nro_arma.required' => "Numero de Arma obligatorio",
            'nro_arma.min'      => "El minimo requerido es 3 caracteres",
            'situacion.exists'  => "Situación de arma no existe"
        ];
    }
}
