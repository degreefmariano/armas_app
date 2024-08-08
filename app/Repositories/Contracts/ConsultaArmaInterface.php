<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface ConsultaArmaInterface
{
    public function getArmasFiltros(Request $request);
    
    public function getArmaClave(Request $request);

    public function getArmaClaveAsignar(Request $request);
    
}
