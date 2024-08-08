<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Arma;
use App\Models\Personal;
use App\Models\VistaArma;
use Illuminate\Http\Request;
use App\Events\PersonalCambioUnidadMessage;
use App\Events\UpdateCambioPersonal;
use App\Repositories\Contracts\CambioUnidadPersonalInterface;
use App\Http\Resources\PersonalCambioUnidad\PersonalCambioUnidadCollectionResource;

final class CambioUnidadPersonalRepository implements CambioUnidadPersonalInterface
{
    protected VistaArma $vistaArmaModel;
    protected Personal  $personalModel;
    protected Arma $armaModel;

    public function __construct(
        VistaArma $vistaArmaModel, 
        Personal $personalModel,
        Arma $armaModel
        )
    {
        $this->vistaArmaModel = $vistaArmaModel;
        $this->personalModel  = $personalModel;
        $this->armaModel      = $armaModel;
    }

    public function getPersonalCambioUnidad(Request $request)
    {
        $userCodUd = Auth('sanctum')->user()->cod_ud;

        $armasPersonalQuery = $this->vistaArmaModel
            ->select(
                'vista_arma.nro_ficha',
                'personal.nlegajo_ps',
                'personal.nombre_ps',
                'vista_arma.ud_ar',
                'vista_arma.nom_ud as nom_ud_ar',
                'personal.ud_ps',
                'personal.nom_ud as nom_ud_ps',
                'personal.fecha_cambio',
                'personal.decreto'
            )
            ->leftJoin('personal', function ($join) {
                $join->on('vista_arma.personal_legajo', '=', 'personal.nlegajo_ps');                    
            })
            ->whereRaw('vista_arma.ud_ar != personal.ud_ps')
            ->where('vista_arma.situacion', Arma::SITUACION_SERVICIO)
            ->where('personal.ud_ps', $userCodUd);

        $personalCambioUnidad = $armasPersonalQuery->paginate($request->offset ?? 15);

        return new PersonalCambioUnidadCollectionResource($personalCambioUnidad);
    }

    public function updatePersonalCambioUnidad(int $ficha, Request $request)
    { 
        $auth =  Auth('sanctum')->user();
        $arma = $this->armaModel->find($ficha);
       
        $arma->ud_ar = (int)$request->cod_ud_ps;
        $arma->update();

        if ($arma) {
            event(new UpdateCambioPersonal('Cambio de unidad Actualizado', $auth));
        }

        return true;
    }
}
