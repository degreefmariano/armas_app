<?php

namespace App\Http\Requests\SubSituacionArma;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SituacionRequest extends FormRequest
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
            'cod_ud' => [Rule::exists('unidades','cod_ud')],
        ];
    }

    public function messages()
    {
        return [
            'cod_ud.exists' => "El código de unidad no existe",
        ];
    }
}
