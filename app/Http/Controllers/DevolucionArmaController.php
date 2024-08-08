<?php

namespace App\Http\Controllers;

use App\Http\Requests\Devolucion\DevuelveMasivaArmaRequest;
use App\Http\Requests\Devolucion\ListadoDevolucionArmaRequest;
use App\Models\Devolucion;
use Illuminate\Http\Request;
use App\Repositories\Contracts\DevolucionArmaInterface;

class DevolucionArmaController extends Controller
{
    protected $repository;

    public function __construct(DevolucionArmaInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function devolverArmasMasiva(DevuelveMasivaArmaRequest $request)
    { 
        try {
            $devolverArmasMasiva = $this->repository->devolverArmasMasiva($request);
            return api()->ok('Devolución exitosa', $devolverArmasMasiva);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());;
        }
    }

    public function getDevolucionArmaTipo(ListadoDevolucionArmaRequest $request)
    { 
        try {
            if ($request->tipo_devolucion == Devolucion::DEVOLUCION_PERSONAL) {
                $tipo = "Personal";
            } else {
                $tipo = "Unidad";
            }
            
            $devoluciones = $this->repository->getDevolucionArmaTipo($request);
            return api()->ok('Listado de Devoluciones a '. $tipo, $devoluciones);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

}
