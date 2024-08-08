<?php

namespace App\Http\Requests\Importar;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ImportarArmaRequest extends FormRequest
{
    protected $stopOnFirstFailure = false;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'file'       => ['required', 'mimes:xlsx', 'file_name:template_armas_cortas.xlsx'],
            'tipo'       => ['required'],
            'fecha_alta' => ['required', 'before_or_equal:today'],
            'obs'        => ['required', 'string', 'min:5'],
        ];
    }

    public function messages()
    {
        return [
            'file.required'              => 'El archivo es obligatorio',
            'file.mimes'                 => 'Formato incorrecto de archivo',
            'file_name'                  => 'El nombre del archivo debe ser template_armas_cortas.xlsx',
            'tipo.required'              => 'El tipo de archivo es obligatorio',
            'fecha_alta.required'        => 'La fecha de alta es obligatoria',
            'fecha_alta.before_or_equal' => 'La fecha de alta no puede ser posterior a hoy',
            'obs.required'               => 'El campo observaciones es obligatorio',
            'obs.min'                    => 'El campo observaciones debe contener al menos 5 caracteres'
        ];
    }
}
