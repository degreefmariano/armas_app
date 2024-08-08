<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface UserInterface
{
    public function index(Request $request);

    public function store(Request $request);

    public function getDptos();

    public function getLocalidades(Request $request);

    public function updateUser(Request $request);

    public function cambiarPassword(Request $request);

    public function blanquearPassword(Request $request);

    public function roles();

    public function estadosUsr();

    public function getGestionUsrPersonal(Request $request);
    
    public function getUser(Request $request);

}
