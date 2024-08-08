<?php

namespace App\Http\Requests\CuibArma;

use App\Rules\Cuib\CuibCreateExistsRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateCuibArmaRequest extends FormRequest
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
            'nro_ficha'   => ['int', Rule::exists('arma','nro_ficha'), new CuibCreateExistsRule($this['nro_ficha'], $this['sobre1_cuib'], $this['sobre2_cuib'])],
            'sobre1_cuib' => ['required', 'numeric', 'integer', 'min:0'],
            'sobre2_cuib' => ['required', 'numeric', 'integer', 'min:0'],
            'caja_cuib'   => ['required', 'string', 'max:20'],
            'fecha_cuib' =>  ['required', 'date_format:Y-m-d', 'before_or_equal:today'],          
        ];
    }

    public function messages()
    {
        return [
            'nro_ficha.int'              => "El numero de ficha debe ser un entero",
            'nro_ficha.exists'           => "El numero de ficha no existe",
            'sobre1_cuib.numeric'        => "Debe ingresar solo números",
            'sobre1_cuib.min'            => "Sobre 1 no puede ser negativo",
            'sobre1_cuib.required'       => "Sobre 1 es obligatorio",
            'sobre2_cuib.numeric'        => "Debe ingresar solo números",
            'sobre2_cuib.min'            => "Sobre 2 no puede ser negativo",
            'sobre2_cuib.required'       => "Sobre 2 es obligatorio",
            'caja_cuib.string'           => "El formato es incorrecto para numero de caja",
            'caja_cuib.max'              => "El maximo permitido es 20 caracteres",
            'caja_cuib.required'         => "Caja Cuib es obligatorio",
            'fecha_cuib.date'            => "El formato de fecha cuib es incorrecta",
            'fecha_cuib.before_or_equal' => "Fecha Cuib no puede ser posterior a hoy",
            'fecha_cuib.required'        => "La fecha Cuib es obligatoria",
        ];
    }
}
