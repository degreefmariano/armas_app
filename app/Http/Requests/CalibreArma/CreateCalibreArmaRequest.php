<?php

namespace App\Http\Requests\CalibreArma;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateCalibreArmaRequest extends FormRequest
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
            'descripcion' => ['string', 'max:50']          
        ];
    }

    public function messages()
    {
        return [
            'descripcion.max' => "El maximo permitido es 50 caracteres"
        ];
    }
}
