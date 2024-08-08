<?php

namespace App\Rules\User;

use App\Models\CuibArma;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class UserExistsRule implements Rule
{

    public function __construct(private $nlegajo_ps)
    {
        //
    }


    public function passes($attribute, $value)
    {  
        $legajo = User::where(['legajo' => $this->nlegajo_ps])->first();
        if ($legajo) {
            return false;
        }
        return true;
    }

    public function message()
    {
        return 'El usuario ya existe en base de datos';
    }
}
