<?php

namespace App\Http\Requests\Entrega;

use App\Rules\Entrega\TipoEntregaPersonalRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EntregaPersonalArmaPdfRequest extends FormRequest
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
            'id_entrega' => ['required', Rule::exists('entrega','id'), new TipoEntregaPersonalRule()],
        ];
    }

    public function messages()
    {
        return [
            'id_entrega.required' => "El código de entrega es requerido",
            'id_entrega.exists'   => "Código de entrega inexistente",
        ];
    }
}
