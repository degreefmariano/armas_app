<?php

namespace App\Http\Requests\Devolucion;

use Illuminate\Validation\Rule;
use App\Rules\Arma\CheckArmaEnServicioRule;
use App\Rules\Arma\CheckArmaMismaDependenciaRule;
use Illuminate\Foundation\Http\FormRequest;

class DevuelveMasivaArmaRequest extends FormRequest
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
            'armas.*'   => ['required', Rule::exists('arma','nro_ficha')],
            'armas'     => ['array'],
            'unidad'    => ['required', Rule::exists('unidades','cod_ud')],
            'subunidad' => ['required', Rule::exists('subunidades','cod_subud')],
            'obs'       => ['nullable', 'string', 'between:3,500'],
            
        ];
    }

    public function messages()
    {
        return [
            'armas.*.required'   => "El/las Arma/s es requerido",
            'armas.*.exists'     => "El/las Arma/s no existe",
            'armas.array'        => "Armas debe ser de tipo array",
            'unidad.exists'      => "La unidad no existe",
            'unidad.required'    => "Debe seleccionar una unidad",
            'subunidad.exists'   => "La subunidad no existe",
            'subunidad.required' => "Debe seleccionar una subunidad",
            'obs.between'        => "Observaciones: debe ingresar entre 3 y 500 caracteres"
        ];
    }
}
