<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\UsoArmaInterface;

class UsoArmaController extends Controller
{
    protected $repository;

    public function __construct(UsoArmaInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function getUsosArma()
    {
        try {
            $usosArma = $this->repository->getUsosArma();
            return api()->ok('Usos de armas', $usosArma);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }
}
