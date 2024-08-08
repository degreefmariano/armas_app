<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\MedidaCalibreArmaInterface;

class MedidaCalibreArmaController extends Controller
{
    protected $repository;

    public function __construct(MedidaCalibreArmaInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function getMedidaCalibreArma()
    {
       try {
            $medidaCalibreArma = $this->repository->getMedidaCalibreArma();
            return api()->ok('Medida Calibre de armas', $medidaCalibreArma);
       } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
       }
    }
}
