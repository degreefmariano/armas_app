<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Models\Rol;
use App\Models\EstadoUsr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\UserInterface;
use App\Http\Resources\User\UserCollectionResource;
use App\Http\Resources\Departamento\DepartamentoCollectionResource;
use App\Http\Resources\Localidad\LocalidadCollectionResource;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\Rol\RolCollectionResource;
use App\Http\Resources\Rol\RolResource;
use App\Http\Resources\EstadosUsr\EstadosUsrCollectionResource;
use App\Http\Resources\EstadosUsr\EstadosUsrResource;
use App\Http\Resources\Personal\PersonalResource;
use App\Models\Departamento;
use App\Models\Localidad;
use App\Models\Personal;

final class UserRepository implements UserInterface
{
    protected User $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function index(Request $request)
    {
        return new UserCollectionResource($this->userModel->index($request,$request['page'],    
        $request['offset']));
    }

    public function getDptos()
    {
        return new DepartamentoCollectionResource(Departamento::all());
    }

    public function getLocalidades(Request $request)
    {
        return new LocalidadCollectionResource(Localidad::where('id_departamento', $request->id)->get());
    }

    public function store(Request $request)
    {
        return new UserResource($this->userModel->store($request));
    }

    public function updateUser(Request $request)
    {
        return new UserResource($this->userModel->updateUser($request));
    }

    public function cambiarPassword(Request $request)
    {
        return new UserResource($this->userModel->cambiarPassword($request)); 
    }

    public function blanquearPassword(Request $request)
    {
        return new UserResource($this->userModel->blanquearPassword($request)); 
    }

    public function roles()
    {
        return new RolCollectionResource(Rol::all());
    }

    public function estadosUsr()
    {
        return new EstadosUsrCollectionResource(EstadoUsr::all());
    }

    public function getGestionUsrPersonal(Request $request)
    {
        return new UserResource(User::where('legajo', $request->legajo)->first());
    }

    public function getUser(Request $request)
    {
        return new PersonalResource(Personal::where('nlegajo_ps', $request->legajo)->first());
    }

    
}
