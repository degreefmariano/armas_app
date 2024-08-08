<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    protected $stopOnFirstFailure = false;

    public function authorize()
    {
        return request();
    }

    public function prepareForValidation()
    { 
        if ($this->input('usuario')) 
        {
            $this->merge([
                'email' => strtoupper($this->input('usuario'). config('constants.DOMINIO_MAIL_USERS'))]);
        }
    }

    public function rules()
    {
        return [
            'email' => ['min:10', 'max:35', Rule::unique('users')],
            'legajo' => ['required','integer', Rule::exists('personal','nlegajo_ps'), Rule::unique('users')],
            'name'  => ['required', Rule::unique('users')],  
            'usuario'  => 'required', 
            'documento' => [Rule::unique('users')],
            'cuil' => [Rule::unique('users')],
            'rol' => ['required', 'integer', 'exists:roles,id'],  
            'unidad' => ['required', Rule::exists('unidades','cod_ud')],
            'subunidad' =>['required', Rule::exists('subunidades','cod_subud')],
            'localidad' =>'required|exists:localidad,id_localidad',
        ];
    }

    public function messages() 
    {
        return [
            'email.unique' => 'El usuario ya está en uso.',
            'legajo.required' => 'El legajo es obligatorio.',
            'legajo.integer' => 'El legajo debe ser un numero entero.',
            'legajo.exists' => 'El legajo no existe en la base de datos.',
            'legajo.unique' => 'El legajo ya está en uso.',
            'name.required' => 'El nombre es obligatorio',
            'name.unique' => 'El nombre ya existe',
            'usuario.required' => 'El usuario es obligatorio',
            'documento.unique' => 'El documento ya existe',
            'cuil.unique' => 'El cuil ya existe',
            'rol.required' => 'El Rol es obligatorio.',
            'rol.integer' => 'El Rol debe ser un numero entero.',
            'rol.exists' => 'El Rol no existe en la base de datos.',
            'unidad.required' => 'La unidad es obligatoria.',
            'unidad.exists' => 'La unidad no existe en la base de datos.',
            'subunidad.required' => 'La subunidad es obligatoria.',
            'subunidad.exists' => 'La subunidad no existe en la base de datos.',
            'localidad.exists' => 'La localidad no existe en la base de datos.',
            'localidad.required' => 'La localidad es obligatoria.',
        ];
    }
}
