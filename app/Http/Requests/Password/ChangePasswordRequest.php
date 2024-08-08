<?php

namespace App\Http\Requests\Password;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

    return [
        'newPassword'    => 'required|confirmed|max:15|min:6|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
        'passwordActual' => [
            'required',
            function ($attribute, $value, $fail) {
            if (!Hash::check($value, auth()->user()->password)) {
             $fail('La contraseña actual no es valida.');
            }
         },
        ],
    ];

    }

    public function messages()
    {
        return [
            'newPassword.required' => 'La contraseña es obligatoria',
            'newPassword.regex' => 'La contraseña debe estar entre 6 a 15 caracteres y contener letras y numeros',
            'newPassword.confirmed' => 'La confirmacion de la contraseña no coincide con la nueva contraseña',
        ];
    }
}
