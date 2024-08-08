<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Personal\UnidadRequest;
use App\Http\Requests\Personal\PersonalRequest;
use App\Repositories\Contracts\PersonalInterface;
use App\Http\Requests\Personal\PersonalNombreRequest;
use App\Http\Requests\User\GestionUsrPersonalRequest;
use App\Http\Requests\Personal\PersonalHistorialRequest;
use App\Http\Requests\User\GestionUsrPersonalNombreRequest;
use App\Http\Requests\Personal\PersonalHistorialNombreRequest;
use App\Http\Requests\Personal\PersonalDevolucionArmaExistsRequest;
use App\Http\Requests\Personal\PersonalDevolucionArmaUnidadRequest;
use App\Http\Requests\Personal\PersonalDevolucionArmaRequest;
use App\Http\Requests\Personal\ConsultaPersonalRequest;

class PersonalController extends Controller
{

    protected $repository;

    public function __construct(PersonalInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getPersonal(PersonalRequest $request)
    {
        try {
            $personal = $this->repository->getPersonal($request);
            return api()->ok('Resultado', $personal);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function getPersonalDevolucion(PersonalDevolucionArmaExistsRequest $request1, PersonalDevolucionArmaUnidadRequest $request2, PersonalDevolucionArmaRequest $request3)
    {
        try {
            $personal = $this->repository->getPersonalDevolucion($request1, $request2, $request3);
            return api()->ok('Resultado', $personal);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function getPersonalNombre(PersonalNombreRequest $request)
    {
        try {
            $personalNombre = $this->repository->getPersonalNombre($request);
            return api()->ok('Resultado', $personalNombre);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function getUnidades()
    {
        try {
            $unidades = $this->repository->getUnidades();
            return api()->ok('Resultado', $unidades);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function getSubunidades(UnidadRequest $request)
    {
        try {
            $subunidades = $this->repository->getSubunidades($request);
            return api()->ok('Resultado', $subunidades);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function getSubunidadesArmasAsignadas()
    {
        try {
            $subunidades = $this->repository->getSubunidadesArmasAsignadas();
            return api()->ok('Resultado', $subunidades);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function getUsersSubunidades(UnidadRequest $request)
    {
        try {
            $subunidades = $this->repository->getUsersSubunidades($request);
            return api()->ok('Resultado', $subunidades);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function getPersonalHistorial(PersonalHistorialRequest $request)
    {
        try {
            $personalHistorial = $this->repository->getPersonalHistorial($request);
            return api()->ok('Resultado', $personalHistorial);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }
    public function getPersonalNombreHistorial(PersonalHistorialNombreRequest $request)
    {
        try {
            $personalNombre = $this->repository->getPersonalNombreHistorial($request);
            return api()->ok('Resultado', $personalNombre);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function getPersonalArmaActual(PersonalHistorialRequest $request)
    {
        try {
            $personalArmaActual = $this->repository->getPersonalArmaActual($request);
            return api()->ok('Resultado', $personalArmaActual);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function getGestionUsrPersonal(GestionUsrPersonalRequest $request)
    {
        try {
            $personal = $this->repository->getGestionUsrPersonal($request);
            return api()->ok('Resultado', $personal);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function getGestionUsrPersonalNombre(GestionUsrPersonalNombreRequest $request)
    {
        try {
            $personalNombre = $this->repository->getGestionUsrPersonalNombre($request);
            return api()->ok('Resultado', $personalNombre);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function getConsultaPersonal(ConsultaPersonalRequest $request)
    {
        try {
            $consultaPersonal = $this->repository->getConsultaPersonal($request);
            return api()->ok('Resultado', $consultaPersonal);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }
}
