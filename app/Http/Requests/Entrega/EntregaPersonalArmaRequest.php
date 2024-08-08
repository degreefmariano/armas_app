<?php

namespace App\Http\Requests\Entrega;

use App\Rules\Arma\CheckArmaEnDepositoRule;
use App\Rules\Arma\ValidaPersonalUdUsrRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EntregaPersonalArmaRequest extends FormRequest
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
            'nro_ficha'     => ['required', Rule::exists('arma','nro_ficha'), new CheckArmaEnDepositoRule($this['nro_ficha'])],
            'legajo'        => ['required', Rule::exists('personal','nlegajo_ps'), new ValidaPersonalUdUsrRule($this['legajo'])],
            'cargadores'    => ['required', 'numeric', 'integer', 'min:0', 'max:3'],
            'municiones'    => ['required', 'numeric', 'integer', 'min:0', 'max:34'],
            'fecha_entrega' => ['required', 'date', 'before_or_equal:today'],
            'obs'           => ['nullable', 'string', 'between:3,500']
        ];
    }

    public function messages()
    {
        return [
            'nro_ficha.required'            => "Debe seleccionar un arma",
            'nro_ficha.exists'              => "El arma no existe",
            'legajo.required'               => "Debe seleccionar un personal",
            'legajo.exists'                 => "El legajo no existe",
            'cargadores.numeric'            => "Debe ingresar solo números",
            'cargadores.required'           => "Debe ingresar cantidad de cargadores",
            'cargadores.min'                => "El minimo de cargadores es 0",
            'cargadores.max'                => "El máximo de cargadores es 3",
            'municiones.required'           => "Debe ingresar cantidad de municiones",
            'municiones.numeric'            => "Debe ingresar solo números",
            'municiones.min'                => "El minimo de municiones es 0",
            'municiones.max'                => "El máximo de municiones es 34",
            'fecha_entrega.required'        => "Fecha de alta es obligatorio",
            'fecha_entrega.date'            => "Formato de fecha incorrecto",
            'fecha_entrega.before_or_equal' => "Fecha entrega no puede ser posterior a hoy",
            'obs.between'                   => "Observaciones: debe ingresar entre 3 y 500 caracteres"
        ];
    }
}
