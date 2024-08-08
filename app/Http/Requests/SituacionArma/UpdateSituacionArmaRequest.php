<?php

namespace App\Http\Requests\SituacionArma;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'nom_situacion' => ['string', 'max:50']          
        ];
    }

    public function messages()
    {
        return [
            'nom_situacion.max' => "El maximo permitido es 50 caracteres"
        ];
    }
}
