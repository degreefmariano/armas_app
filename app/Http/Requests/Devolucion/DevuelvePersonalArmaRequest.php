<?php

namespace App\Http\Requests\Devolucion;

use Illuminate\Validation\Rule;
use App\Rules\Arma\CheckArmaEnServicioRule;
use Illuminate\Foundation\Http\FormRequest;

class DevuelvePersonalArmaRequest extends FormRequest
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
            'nro_ficha'  => ['required', Rule::exists('arma','nro_ficha'), new CheckArmaEnServicioRule($this['nro_ficha'])],
            'legajo'     => ['required', Rule::exists('personal','nlegajo_ps')],
            'cargadores' => ['nullable', 'numeric', 'integer', 'max:2'],
            'municiones' => ['nullable', 'numeric', 'integer', 'min:0', 'max:34'],
            'estado'     => ['nullable', Rule::exists('estado','cod_estado')],
            'obs'        => ['nullable', 'string', 'between:3,500']
        ];
    }

    public function messages()
    {
        return [
            'nro_ficha.required' => "Debe seleccionar un arma",
            'nro_ficha.exists'   => "El arma no existe",
            'legajo.required'    => "Debe seleccionar un personal",
            'legajo.exists'      => "El legajo no existe",
            'cargadores.numeric' => "Debe ingresar solo números",
            'cargadores.max'     => "Solo puede ingresar un maximo de 2 cargadores",
            'municiones.numeric' => "Debe ingresar solo números",
            'municiones.min'     => "Solo puede ingresar un minimo de 0 munición",
            'municiones.max'     => "Solo puede ingresar un maximo de 34 municiones",
            'estado.exists'      => "El estado no existe",
            'obs.between'        => "Observaciones: debe ingresar entre 3 y 500 caracteres",
        ];
    }
}
