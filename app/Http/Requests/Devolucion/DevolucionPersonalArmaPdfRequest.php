<?php

namespace App\Http\Requests\Devolucion;

use App\Rules\Devolucion\TipoDevolucionPersonalRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DevolucionPersonalArmaPdfRequest extends FormRequest
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
            'id_devolucion' => ['required', Rule::exists('devolucion','id'), new TipoDevolucionPersonalRule()],
        ];
    }

    public function messages()
    {
        return [
            'id_devolucion.required' => "El código de devolucion es requerido",
            'id_devolucion.exists'   => "Código de devolucion inexistente",
        ];
    }
}
