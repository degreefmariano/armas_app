<?php

namespace App\Http\Requests\Entrega;

use App\Rules\Arma\CheckArmaMismaDependenciaRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EntregaMasivaArmaLargaRequest extends FormRequest
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
            'legajo'     => ['required', Rule::exists('personal','nlegajo_ps')],
            'unidad'     => ['required', Rule::exists('unidades','cod_ud')],
            'subunidad'  => ['required', Rule::exists('subunidades','cod_subud')],
            'armas'      => ['array', new CheckArmaMismaDependenciaRule($this['subunidad'], $this['armas'])],
            'armas.*'    => [Rule::exists('arma','nro_ficha')],
            'obs'        => ['nullable', 'string', 'between:3,500']
        ];
    }

    public function messages()
    {
        return [
            'legajo.exists'      => "El legajo no existe",
            'legajo.required'    => "Debe seleccionar un personal",
            'unidad.exists'      => "La unidad no existe",
            'unidad.required'    => "Debe seleccionar una unidad",
            'subunidad.exists'   => "La subunidad no existe",
            'subunidad.required' => "Debe seleccionar una subunidad",
            'armas.array'        => "Armas debe ser de tipo array",
            'armas.*.exists'     => "El Arma no existe",
            'obs.between'        => "Observaciones: debe ingresar entre 3 y 500 caracteres"
        ];
    }
}
