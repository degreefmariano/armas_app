<?php

namespace App\Rules\Entrega;

use App\Models\Entrega;
use Illuminate\Contracts\Validation\Rule;

class TipoEntregaPersonalRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        $entrega = Entrega::find($value);

        if ($entrega->tipo == Entrega::ENTREGA_MASIVA) {
            return false;
        }
        return true;
    }

    public function message()
    {
        return 'ERROR...!!! La entrega seleccionada no es personalizada';
    }
}
