<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface PersonalArmaInterface
{
    public function asignarArmaPersonal(Request $request);

    public function devolverArmaPersonal(Request $request);

    public function devolucionEspecialArmaPersonal(Request $request);
    
}
