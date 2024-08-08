<?php

namespace App\Http\Requests\Devolucion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListadoDevolucionArmaRequest extends FormRequest
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
            'fecha_desde'         => ['nullable', 'date', 'required_with:fecha_hasta'],
            'fecha_hasta'         => ['nullable', 'date', 'after_or_equal:fecha_desde', 'required_with:fecha_desde'],
            'ud_recibe'           => [Rule::exists('unidades','cod_ud')],
            'personal_devuelve'   => [Rule::exists('personal','nlegajo_ps')],
            'ud_arma_anterior'    => [Rule::exists('unidades','cod_ud')],
            'subud_arma_anterior' => [Rule::exists('subunidades','cod_subud')],
            'tipo_devolucion'     => ['required', Rule::in([1,2])]
        ];
                
    }

    public function messages()
    {
        return [
            'fecha_desde.date'           => "Formato incorrecto en fecha desde",
            'fecha_desde.required_with'  => "Se debe ingresar ambas fechas",
            'fecha_hasta.date'           => "Formato incorrecto en fecha hasta",
            'fecha_hasta.required_with'  => "Se debe ingresar ambas fechas",
            'fecha_hasta.after_or_equal' => "La fecha hasta debe ser igual o posterior a fecha desde",
            'ud_recibe.exists'           => "La Unidad seleccionada no existe.",
            'personal_devuelve.exists'   => "El legajo no existe.",
            'ud_arma_anterior.exists'    => "La Unidad seleccionada no existe.",
            'subud_arma_anterior.exists' => "La Sub Unidad seleccionada no existe.",
            'tipo_devolucion.required'   => "Se debe ingresar el tipo de devolucion",
            'tipo_devolucion.in'         => "Tipo de devolucion incorrecto"
        ];
    }
}
