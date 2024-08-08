<?php

namespace App\Rules\Devolucion;

use App\Models\Devolucion;
use Illuminate\Contracts\Validation\Rule;

class TipoDevolucionMasivaRule implements Rule
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
        $entrega = Devolucion::find($value);

        if ($entrega AND $entrega->tipo == Devolucion::DEVOLUCION_PERSONAL) {
            return false;
        }
        return true;
    }

    public function message()
    {
        return 'ERROR...!!! La devolucion seleccionada no es de unidad';
    }
}
