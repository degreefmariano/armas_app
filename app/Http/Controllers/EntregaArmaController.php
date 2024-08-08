<?php

namespace App\Http\Controllers;

use App\Http\Requests\Entrega\EntregaMasivaArmaLargaRequest;
use App\Http\Requests\Entrega\EntregaMasivaArmaRequest;
use App\Http\Requests\Entrega\ListadoEntregaArmaRequest;
use App\Models\Entrega;
use Illuminate\Http\Request;
use App\Repositories\Contracts\EntregaArmaInterface;

class EntregaArmaController extends Controller
{
    protected $repository;

    public function __construct(EntregaArmaInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function getEntregaArmaTipo(ListadoEntregaArmaRequest $request)
    {
        try {
            if ($request->tipo_entrega == Entrega::ENTREGA_PERSONAL) {
                $tipo = "Personal";
            } else {
                $tipo = "Unidad";
            }
            
            $entregas = $this->repository->getEntregaArmaTipo($request);
            return api()->ok('Listado de Entregas a '. $tipo, $entregas);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function asignarArmaMasiva(EntregaMasivaArmaRequest $request)
    { 
        try {
            $entregaMasiva = $this->repository->asignarArmaMasiva($request);
            return api()->ok('Entrega masiva de armas', $entregaMasiva);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function asignarArmaMasivaLargas(EntregaMasivaArmaLargaRequest $request)
    {
        try {
            $entregaMasivaLargas = $this->repository->asignarArmaMasivaLargas($request);
            return api()->ok('Entrega masiva de armas largas a dependencias', $entregaMasivaLargas);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

}
