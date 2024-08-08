<?php

namespace App\Http\Requests\Consultas;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArmasFiltrosRequest extends FormRequest
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
            'nro_arma'              => ['nullable', Rule::exists('arma','nro_arma')],
            'cod_tipo_arma'         => ['nullable', Rule::exists('tipo_arma','id')],
            'cod_marca'             => ['nullable', Rule::exists('marca_arma','id')],
            'cod_calibre_principal' => ['nullable', Rule::exists('calibre','id')],
            'estado'                => ['nullable', Rule::exists('estado','cod_estado')],
            'situacion'             => ['nullable', Rule::exists('situacion','cod_situacion')],
            'subsituacion'          => ['nullable', Rule::exists('subsituacion','id')],
            'arma_corta_larga'      => ['nullable', Rule::exists('corta_larga','id')],
            'ud_ar'                 => ['nullable', Rule::exists('unidades','cod_ud')],
            'subud_ar'              => ['nullable', Rule::exists('subunidades','cod_subud')]
        ];
    }

    public function messages()
    {
        return [
            'nro_arma.exists'              => "El nro de arma no existe",
            'cod_tipo_arma.exists'         => "El codigo tipo de arma no existe",
            'cod_marca.exists'             => "La marca de arma no existe",
            'cod_calibre_principal.exists' => "El codigo calibre de arma no existe", 
            'estado.exists'                => "El estado de arma no existe", 
            'situacion.exists'             => "Situación de arma no existe",
            'subsituacion.exists'          => "Subsituación de arma no existe",
            'arma_corta_larga.exists'      => "Clasificación de arma no existe",
            'ud_ar.exists'                 => "Unidad destino no existe",
            'subud_ar.exists'              => "Subunidad destino no existe"
        ];
    }
}
