<?php

namespace App\Http\Requests\Arma;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\Arma\ArmaUpdateExistsRule;

class UpdateArmaRequest extends FormRequest
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
            'ficha'                    => [Rule::exists('arma','nro_ficha')],
            'nro_arma'                 => ['required', Rule::exists('arma','nro_arma')],
            'cod_tipo_arma'            => ['required', Rule::exists('tipo_arma','id')],
            'cod_marca'                => ['required', Rule::exists('marca_arma','id')],
            'cod_calibre_principal'    => ['required', Rule::exists('calibre','id')],
            'modelo'                   => ['required', 'string', 'between:3,20'],
            'medida_calibre_principal' => ['nullable', Rule::exists('medida_calibre','id')],
            'largo_canon_principal'    => ['nullable', 'string', 'between:3,20'],
            'arma_corta_larga'         => ['nullable', Rule::exists('corta_larga','id')],
            'cod_estado'               => ['required', Rule::exists('estado','cod_estado')],       
            'clasificacion'            => ['nullable', Rule::exists('uso_arma','id')],
            'fecha_alta'               => ['required', 'date', 'before_or_equal:today'],
            'obs'                      => ['nullable', 'string', 'between:3,500'],
        ];
    }

    public function messages()
    {
        return [
            'ficha.exists'                    => "Nro de ficha no existe",
            'nro_arma.required'               => "Numero de Arma obligatorio",
            'nro_arma.exists'                 => "Numero de Arma no existe",
            'cod_tipo_arma.required'          => "Tipo de arma es obligatorio",
            'cod_tipo_arma.exists'            => "Tipo de arma no existe",
            'cod_marca.required'              => "Marca es obligatorio",
            'cod_marca.exists'                => "Marca no existe",
            'cod_calibre_principal.required'  => "Calibre principal es obligatorio",
            'cod_calibre_principal.exists'    => "Calibre principal no existe",
            'modelo.between'                  => "En el modelo debe ingresar entre 3 y 20 caracteres, sin espacios entre medio, solo letras y números",
            'medida_calibre_principal.exists' => "Medida calibre ppal no existe",
            'largo_canon_principal.between'   => "En el largo del canon principal debe ingresar entre 3 y 20 caracteres, sin espacios entre medio, solo letras y números",
            'arma_corta_larga.exists'         => "Tamaño de arma no existe",
            'cod_estado.required'             => "Estado es obligatorio",
            'cod_estado.exists'               => "Estado no existe",
            'clasificacion.exists'            => "Uso de arma no existe",
            'fecha_alta.required'             => "Fecha de alta es obligatorio",
            'fecha_alta.date'                 => "Formato de fecha incorrecto",
            'fecha_alta.before_or_equal'      => "Fecha alta no puede ser posterior a hoy",
            'obs.between'                     => "Observaciones: debe ingresar entre 3 y 500 caracteres",
        ];
    }
}
