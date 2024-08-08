<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\CortaLargaArmaInterface;

class CortaLargaArmaController extends Controller
{
    protected $repository;

    public function __construct(CortaLargaArmaInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function getCortaLargaArma()
    {
        try {
            $cortaLargaArma = $this->repository->getCortaLargaArma();
            return api()->ok('Corta Larga de armas', $cortaLargaArma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());;
        }
    }
}
