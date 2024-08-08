<?php

namespace App\Http\Requests\Jobs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobIdRequest extends FormRequest
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
            'jobId' => ['required', Rule::exists('import_armas_jobs','id')]
        ];
    }

    public function all($keys = null)
    {
        return array_merge(
            parent::all(),
            [
                'jobId' => $this->route('jobId'),
            ]
        );
    }

    public function messages()
    {
        return [
            'jobId.required' => "El ID del proceso es requerido",
            'jobId.exists'   => "El Proceso no existe"
        ];
    }
}