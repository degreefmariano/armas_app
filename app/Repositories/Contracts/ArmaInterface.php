<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface ArmaInterface
{
    public function getArma(Request $request);

    public function createArma(Request $request);

    public function updateArma($ficha, Request $request);

    public function updateEstadoArma($ficha, Request $request);

    public function updateSituacionArma($ficha, Request $request);

    public function getHistorialArma(Request $request);

    public function getArmasDepositoPorUd(Request $request);

    public function getArmasUdDevuelve(Request $request);

    public function getArmasDependenciaAUdDevuelve(Request $request);
}
