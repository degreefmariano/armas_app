<?php

namespace App\Providers;

use App\Repositories\CalibreArmaRepository;
use App\Repositories\Contracts\CalibreArmaInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\TipoArmaInterface;
use App\Repositories\TipoArmaRepository;
use App\Repositories\Contracts\MarcaArmaInterface;
use App\Repositories\MarcaArmaRepository;
use App\Repositories\Contracts\UsoArmaInterface;
use App\Repositories\UsoArmaRepository;
use App\Repositories\Contracts\EstadoArmaInterface;
use App\Repositories\EstadoArmaRepository;
use App\Repositories\Contracts\SituacionArmaInterface;
use App\Repositories\SituacionArmaRepository;
use App\Repositories\Contracts\CortaLargaArmaInterface;
use App\Repositories\CortaLargaArmaRepository;
use App\Repositories\Contracts\MedidaCalibreArmaInterface;
use App\Repositories\MedidaCalibreArmaRepository;
use App\Repositories\Contracts\ConsultaArmaInterface;
use App\Repositories\ConsultaArmaRepository;
use App\Repositories\ArmaRepository;
use App\Repositories\CambioUnidadPersonalRepository;
use App\Repositories\Contracts\ArmaInterface;
use App\Repositories\Contracts\CambioUnidadPersonalInterface;
use App\Repositories\Contracts\CuibArmaInterface;
use App\Repositories\Contracts\DevolucionArmaInterface;
use App\Repositories\Contracts\EntregaArmaInterface;
use App\Repositories\Contracts\ImportarArmaInterface;
use App\Repositories\Contracts\PersonalArmaInterface;
use App\Repositories\Contracts\PersonalInterface;
use App\Repositories\Contracts\ReporteArmaInterface;
use App\Repositories\Contracts\SubSituacionArmaInterface;
use App\Repositories\Contracts\UserInterface;
use App\Repositories\CuibArmaRepository;
use App\Repositories\DevolucionArmaRepository;
use App\Repositories\EntregaArmaRepository;
use App\Repositories\ImportarArmaRepository;
use App\Repositories\PersonalArmaRepository;
use App\Repositories\PersonalRepository;
use App\Repositories\ReporteArmaRepository;
use App\Repositories\SubSituacionArmaRepository;
use App\Repositories\UserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TipoArmaInterface::class,TipoArmaRepository::class);
        $this->app->bind(MarcaArmaInterface::class,MarcaArmaRepository::class);
        $this->app->bind(CalibreArmaInterface::class,CalibreArmaRepository::class);
        $this->app->bind(UsoArmaInterface::class,UsoArmaRepository::class);
        $this->app->bind(EstadoArmaInterface::class,EstadoArmaRepository::class);
        $this->app->bind(SituacionArmaInterface::class,SituacionArmaRepository::class);
        $this->app->bind(CortaLargaArmaInterface::class,CortaLargaArmaRepository::class);
        $this->app->bind(MedidaCalibreArmaInterface::class,MedidaCalibreArmaRepository::class);
        $this->app->bind(ConsultaArmaInterface::class,ConsultaArmaRepository::class);
        $this->app->bind(ArmaInterface::class,ArmaRepository::class);
        $this->app->bind(PersonalInterface::class,PersonalRepository::class);
        $this->app->bind(UserInterface::class,UserRepository::class);
        $this->app->bind(CuibArmaInterface::class,CuibArmaRepository::class);
        $this->app->bind(SubSituacionArmaInterface::class,SubSituacionArmaRepository::class);
        $this->app->bind(PersonalArmaInterface::class,PersonalArmaRepository::class);
        $this->app->bind(EntregaArmaInterface::class,EntregaArmaRepository::class);
        $this->app->bind(DevolucionArmaInterface::class,DevolucionArmaRepository::class);
        $this->app->bind(ImportarArmaInterface::class,ImportarArmaRepository::class);
        $this->app->bind(ReporteArmaInterface::class,ReporteArmaRepository::class);
        $this->app->bind(CambioUnidadPersonalInterface::class,CambioUnidadPersonalRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
