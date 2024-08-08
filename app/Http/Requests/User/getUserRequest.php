<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class getUserRequest extends FormRequest
{
    protected $stopOnFirstFailure = false;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'legajo' => ['required','integer' , Rule::exists('personal','nlegajo_ps'), Rule::unique('users')],
        ];
    }

    public function messages() 
    {
        return [
            'legajo.required' => 'El legajo es obligatorio.',
            'legajo.integer' => 'El legajo debe ser un numero entero.',
            'legajo.exists' => 'El legajo no existe en la base de datos.',
            'legajo.unique' => 'El legajo ya está en uso.',
        ];
    } 

}
