<?php

namespace App\Http\Requests\PersonalCambioUnidad;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PersonalCambioUnidadRequest extends FormRequest
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
            'ficha'     => ['required', Rule::exists('arma','nro_ficha')],
            'cod_ud_ps' => ['required', Rule::exists('unidades','cod_ud')]
        ];
    }

    public function all($keys = null)
    {
        return array_merge(
            parent::all(),
            [
                'ficha' => $this->route('ficha'),
            ]
        );
    }

    public function messages()
    {
        return [
            'ficha.required'     => "El nro de ficha del arma es obligatorio.",
            'cod_ud_ps.required' => "El código de unidad es obligatorio"
        ];
    }
}
