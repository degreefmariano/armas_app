<?php

namespace App\Http\Requests\Exportar;

use App\Rules\Arma\CheckArmaEnDepositoRule;
use App\Rules\Arma\ValidaPersonalUdUsrRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExportarReporteArmasRequest extends FormRequest
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
            'cod_tipo_arma'         => ['nullable', Rule::exists('tipo_arma','id')],
            'cod_marca'             => ['nullable', Rule::exists('marca_arma','id')],
            'cod_calibre_principal' => ['nullable', Rule::exists('calibre','id')],
            'estado'                => ['nullable', Rule::exists('estado','cod_estado')],
            'situacion'             => ['nullable', Rule::exists('situacion','cod_situacion')],
            'sub_situacion'         => ['nullable', Rule::exists('subsituacion','id')],
            'arma_corta_larga'      => ['required', Rule::exists('corta_larga','id')],
            'ud_ar'                 => ['nullable', 'required_with:subud_ar', Rule::exists('unidades','cod_ud')],
            'subud_ar'              => ['nullable', Rule::exists('subunidades','cod_subud')]
        ];
    }

    public function messages()
    {
        return [
            'cod_tipo_arma.exists'          => "El tipo de arma no existe",
            'cod_marca.exists'              => "La marca no existe",
            'cod_calibre_principal.exists'  => "El calibre no existe",
            'estado.exists'                 => "El estado no existe",
            'situacion.exists'              => "La situación no existe",
            'sub_situacion.exists'          => "La subsituación no existe",
            'arma_corta_larga.required'     => "La clasificación es obligatoria",
            'arma_corta_larga.exists'       => "La clasificación no existe",
            'ud_ar.exists'                  => 'La unidad no existe',
            'ud_ar.required_with'           => 'Debe seleccionar previamente una unidad',
            'subud_ar.exists'               => 'La subunidad no existe',
        ];
    }
}
