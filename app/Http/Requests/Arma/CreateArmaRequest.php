<?php

namespace App\Http\Requests\Arma;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\Arma\ArmaCreateExistsRule;

class CreateArmaRequest extends FormRequest
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
            'nro_arma'                 => ['required','string', 'between:3,20', new ArmaCreateExistsRule($this['nro_arma'], $this['cod_tipo_arma'], $this['cod_marca'], $this['cod_calibre_principal'])],
            'cod_tipo_arma'            => ['required', Rule::exists('tipo_arma', 'id')],
            'cod_marca'                => ['required', Rule::exists('marca_arma', 'id')],
            'cod_calibre_principal'    => ['required', Rule::exists('calibre', 'id')],
            'modelo'                   => ['required', 'string', 'between:3,20'],
            'medida_calibre_principal' => ['required', Rule::exists('medida_calibre', 'id')],
            'largo_canon_principal'    => ['nullable', 'string', 'between:3,20'],
            'arma_corta_larga'         => ['required', Rule::exists('corta_larga', 'id')],
            'estado'                   => ['required', Rule::exists('estado', 'cod_estado')],
            'clasificacion'            => ['required', Rule::exists('uso_arma', 'id')],
            'fecha_alta'               => ['required', 'date', 'before_or_equal:today'],
            'obs'                      => ['nullable', 'string', 'between:3,500']
        ];
    }
    
    public function messages()
    {
        return [
            'nro_arma.required'                 => "Numero de Arma obligatorio",
            'nro_arma.between'                  => "En el Numero de Arma debe ingresar entre 3 y 20 caracteres, sin espacios entre medio, solo letras y números",
            'cod_tipo_arma.required'            => "Tipo de arma es obligatorio",
            'cod_tipo_arma.exists'              => "Tipo de arma no existe",
            'cod_marca.required'                => "Marca es obligatorio",
            'cod_marca.exists'                  => "Marca no existe",
            'cod_calibre_principal.required'    => "Calibre principal es obligatorio",
            'cod_calibre_principal.exists'      => "Calibre principal no existe",
            'modelo.required'                   => "Modelo es obligatorio",
            'modelo.between'                    => "En el modelo debe ingresar entre 3 y 20 caracteres, sin espacios entre medio, solo letras y números",
            'medida_calibre_principal.required' => "Medida calibre es obligatorio",
            'medida_calibre_principal.exists'   => "Medida calibre ppal no existe",
            'largo_canon_principal.between'     => "En el largo del canon principal debe ingresar entre 3 y 20 caracteres, sin espacios entre medio, solo letras y números",
            'arma_corta_larga.required'         => "Tamaño de arma es obligatorio",
            'arma_corta_larga.exists'           => "Tamaño de arma no existe",
            'estado.required'                   => "Estado de arma es obligatorio",
            'estado.exists'                     => "Estado de arma no existe",
            'clasificacion.required'            => "Uso de arma es obligatorio",
            'clasificacion.exists'              => "Uso de arma no existe",
            'fecha_alta.required'               => "Fecha de alta es obligatorio",
            'fecha_alta.date'                   => "Formato de fecha incorrecto",
            'fecha_alta.before_or_equal'        => "Fecha alta no puede ser posterior a hoy",
            'obs.between'                       => "Observaciones: debe ingresar entre 3 y 500 caracteres",
        ];
    }
}
