<?php

namespace App\Http\Requests\Personal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PersonalHistorialRequest extends FormRequest
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
            'nlegajo_ps' => [Rule::exists('personal','nlegajo_ps')],
        ];
    }

    public function messages()
    {
        return [
            'nlegajo_ps.exists'   => "El nro de legajo no existe",
        ];
    }
}
