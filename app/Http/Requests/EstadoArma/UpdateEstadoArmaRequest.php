<?php

namespace App\Http\Requests\EstadoArma;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEstadoArmaRequest extends FormRequest
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
            'nom_estado' => ['string', 'max:15']          
        ];
    }

    public function messages()
    {
        return [
            'nom_estado.max' => "El maximo permitido es 15 caracteres"
        ];
    }
}
