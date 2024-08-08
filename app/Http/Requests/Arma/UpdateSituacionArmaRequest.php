<?php

namespace App\Http\Requests\Arma;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\Arma\ArmaUpdateSituacionRule;
use App\Rules\Arma\ArmaUpdateSubSituacionRule;
use App\Rules\Arma\CheckSituacionServicioRule;

class UpdateSituacionArmaRequest extends FormRequest
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
            'situacion'              => ['required', Rule::in([2, 3, 4, 5, 6, 7, 8, 9, 11]), new ArmaUpdateSituacionRule($this->ficha, $this['situacion'], $this['sub_situacion'], $this['cod_ud']), new CheckSituacionServicioRule($this->ficha)],
            'obs'                    => ['nullable', 'string', 'between:3,500'],
            'sub_situacion'          => ['nullable', Rule::exists('subsituacion','id'), new ArmaUpdateSubSituacionRule($this->ficha)],
            'trabajo_realizado'      => ['nullable', 'string', 'between:3,1000'],
            'fecha_hecho'            => ['nullable', 'date_format:Y-m-d', 'before_or_equal:today'],
            'lugar_hecho'            => ['nullable', 'string', 'between:3,100'],
            'dep_interviniente'      => ['nullable', 'string', 'between:3,100'],
            'fiscalia_interviniente' => ['nullable', 'string', 'between:3,100'],
            'victimas'               => ['nullable', 'string', 'between:3,250'],
            'imputados'              => ['nullable', 'string', 'between:3,250'],
            'caratula'               => ['nullable', 'string', 'between:3,100'],
            'lugar_deposito'         => ['nullable', 'string', 'between:5,100'],
            'cod_ud'                 => ['required', Rule::exists('unidades','cod_ud')],
            'fecha_movimiento'       => ['nullable', 'date_format:Y-m-d', 'before_or_equal:today'],
            'cuij'                   => ['nullable', 'string', 'between:3,20'],
        ];
    }

    public function messages()
    {
        return [
            'situacion.required'               => "Código de situación es obligatorio",
            'situacion.in'                     => "Código de situación es invalido",
            'obs.between'                      => "Observaciones: debe ingresar entre 3 y 500 caracteres",
            'sub_situacion.exists'             => "Código de subsituación no existe",
            'trabajo_realizado.between'        => "Trabajo Realizado: debe ingresar entre 3 y 1000 caracteres",
            'fecha_hecho.before_or_equal'      => "Fecha del hecho no puede ser posterior a hoy",
            'lugar_hecho.between'              => "Lugar Hecho: debe ingresar entre 3 y 100 caracteres",
            'dep_interviniente.between'        => "Dependencia Interviniente: debe ingresar entre 3 y 100 caracteres",
            'fiscalia_interviniente.between'   => "Fiscalia Interviniente: debe ingresar entre 3 y 100 caracteres",
            'victimas.between'                 => "Victimas: debe ingresar entre 3 y 250 caracteres",
            'imputados.between'                => "Imputados: debe ingresar entre 3 y 250 caracteres",
            'caratula.between'                 => "Caratula: debe ingresar entre 3 y 100 caracteres",
            'lugar_deposito.between'           => "debe ingresar entre 5 y 100 caracteres",
            'cod_ud.required'                  => "Código de unidad es obligatorio",
            'cod_ud.exists'                    => "Código de unidad no existe",
            'fecha_movimiento.before_or_equal' => "Fecha de movimiento no puede ser posterior a hoy",
            'cuij.between'                     => "Cuij: debe ingresar entre 3 y 20 caracteres",
        ];
    }
}
