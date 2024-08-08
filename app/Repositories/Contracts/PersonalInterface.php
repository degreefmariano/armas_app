<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface PersonalInterface
{
    public function getPersonal(Request $request);

    public function getPersonalDevolucion(Request $request);
    
    public function getPersonalNombre(Request $request);

    public function getUnidades();

    public function getSubunidades(Request $request);

    public function getSubunidadesArmasAsignadas();

    public function getUsersSubunidades(Request $request);

    public function getPersonalHistorial(Request $request);

    public function getPersonalNombreHistorial(Request $request);

    public function getPersonalArmaActual(Request $request);

    public function getGestionUsrPersonal(Request $request);

    public function getGestionUsrPersonalNombre(Request $request);

    public function getConsultaPersonal(Request $request);
}
