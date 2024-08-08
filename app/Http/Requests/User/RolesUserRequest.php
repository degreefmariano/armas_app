<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RolesUserRequest extends FormRequest
{
    protected $stopOnFirstFailure = false;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => [Rule::in([1, 2, 3])]
        ];
    }   
}
