<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    protected $stopOnFirstFailure = false;

    public function authorize()
    {
        return true;
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
        $userId = $this->route('id'); // Obtener el ID del usuario actual desde la ruta
        return [
            'email' => [
                //'required',
                'min:10',
                'max:35',
                Rule::unique('users')->ignore($userId, 'id')->where(function ($query) {
                    // Verificar si el email ha sido modificado
                    return $query->where('email', '!=', $this->input('email'));
                }),
            ],

            //FRONT: DATOS DEL PERSONAL
            'id' => ['required', 'integer', Rule::exists('users', 'id')],
            'legajo' => ['required', 'integer', Rule::exists('users', 'legajo')],
            'usuario' => 'required|string|max:255', 
            'documento' => 'required|integer|digits_between:7,9',
            'cuil' => 'digits_between:10,12',
            'cod_ud' => ['required', Rule::exists('unidades','cod_ud')],
            'cod_subud' => ['required', Rule::exists('subunidades','cod_subud')],
            //FRONT: DATOS DEL USUARIO
            // 'obs_usr' => 'string',  
            'estado_usr' => ['required', Rule::in([1, 2])],
            'rol' => ['required', Rule::in([1, 2, 3])],
            'fecha_alta' => ['date'],
            'localidad' =>'required|exists:localidad,id_localidad',     
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'El id es obligatorio.',
            'id.integer' => 'El id debe ser un numero entero.',
            'id.exists' => 'El id no existe en la base de datos.',
            'legajo.required' => 'El legajo es obligatorio.',
            'legajo.integer' => 'El legajo debe ser un numero entero.',
            'legajo.exists' => 'El legajo no existe en la base de datos.',
            'usuario.required' => 'El usuario es obligatorio.',
            'usuario.string' => 'El usuario debe ser un numero entero.',
            'documento.required' => 'El documento es obligatorio.',
            'documento.integer' => 'El documento debe ser un numero entero.',
            'documento.digits_between' => 'El documento debe estar entre 7 y 9 dígitos.',
            'cuil.digits_between' => 'El cuil debe estar entre 10 y 12 dígitos.',
            'cod_ud.required' => 'La unidad es obligatoria.',
            'cod_ud.exists' => 'La unidad no existe en la base de datos.',
            'cod_subud.required' => 'La subunidad es obligatoria.',
            'cod_subud.exists' => 'La subunidad no existe en la base de datos.',
            'rol.exists' => 'El rol no existe en la base de datos.',
            'rol.required' => 'El rol es obligatorio.',
            'localidad.exists' => 'La localidad no existe en la base de datos.',
            'localidad.required' => 'La localidad es obligatoria.',
        ];
    }
}
