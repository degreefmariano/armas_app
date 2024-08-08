<?php

namespace App\Http\Requests\Personal;

use App\Rules\Arma\ValidaPersonalUdUsrRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PersonalRequest extends FormRequest
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
            'nlegajo_ps' => ['required', 'numeric', 'digits_between:5,8', Rule::exists('personal','nlegajo_ps'), new ValidaPersonalUdUsrRule($this['nlegajo_ps'])],
        ];
    }

    public function messages()
    {
        return [
            'nlegajo_ps.required'        => "El nro de legajo es obligatorio",
            'nlegajo_ps.exists'          => "El nro de legajo no existe",
            'nlegajo_ps.numeric'         => "Debe ingresar solo números",
            'nlegajo_ps.digits_between'  => "Nro de legajo fuera de rango",
        ];
    }
}
