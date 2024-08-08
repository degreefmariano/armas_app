<?php

namespace App\Http\Requests\Auditorias;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HistorialLoginAuditoriaRequest extends FormRequest
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
            'fecha_desde'         => ['nullable', 'date', 'required_with:fecha_hasta', 'before_or_equal:today'],
            'fecha_hasta'         => ['nullable', 'date', 'after_or_equal:fecha_desde', 'required_with:fecha_desde', 'before_or_equal:today'],
        ];
    }

    public function messages()
    {
        return [
            'fecha_desde.date'            => "Formato incorrecto en fecha desde",
            'fecha_desde.required_with'   => "Se debe ingresar ambas fechas",
            'fecha_hasta.date'            => "Formato incorrecto en fecha hasta",
            'fecha_hasta.required_with'   => "Se debe ingresar ambas fechas",
            'fecha_hasta.after_or_equal'  => "La fecha hasta debe ser igual o posterior a fecha desde",
            'fecha_desde.before_or_equal' => "Fecha desde no puede ser posterior a hoy",
            'fecha_hasta.before_or_equal' => "Fecha hasta no puede ser posterior a hoy",
        ];
    }
}
