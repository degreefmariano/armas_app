<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Resources\Personal\PersonalArmaActualResource;
use App\Models\Arma;
use App\Models\User;
use App\Models\Unidad;
use App\Models\Personal;
use App\Models\Subunidad;
use Illuminate\Http\Request;
use App\Models\PersonalArma;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\PersonalInterface;
use App\Http\Resources\Personal\PersonalResource;
use App\Http\Resources\Personal\UnidadCollectionResource;
use App\Http\Resources\Personal\PersonalCollectionResource;
use App\Http\Resources\Personal\SubUnidadCollectionResource;
use App\Http\Resources\Personal\PersonalHistoricoArmaResource;
use App\Http\Resources\Personal\PersonalDevolucionArmaResource;
use App\Http\Resources\Personal\ConsultaPersonalResource;

final class PersonalRepository implements PersonalInterface
{
    protected Personal $personalModel;

    public function __construct(Personal $personalModel)
    {
        $this->personalModel = $personalModel;
    }

    public function getPersonal(Request $request)
    {
        return new PersonalResource(Personal::where('nlegajo_ps', $request->nlegajo_ps)->first());
    }


    public function getPersonalDevolucion(Request $request)
    {
        $personalArma = PersonalArma::with(['personal'])
            ->where('legajo', $request->nlegajo_ps)
            ->first();
        return new PersonalDevolucionArmaResource($personalArma);
    }

    public function getUnidades()
    {
        return new UnidadCollectionResource(Unidad::whereRaw("nom_ud NOT LIKE '-%'")->orderBy('nom_ud')->get());
    }

    public function getSubunidades(Request $request)
    {
        return new SubUnidadCollectionResource(Subunidad::where('ud_subud', $request->cod_ud)->get());
    }


    public function getSubunidadesArmasAsignadas()
    {
        $subunidades = Arma::where('ud_ar', Auth('sanctum')->user()->cod_ud)
            ->whereNotNull('subud_ar')
            ->distinct()
            ->pluck('subud_ar')
            ->toArray();

        return new SubUnidadCollectionResource(Subunidad::whereIn('cod_subud', $subunidades)->get());
    }

    public function getUsersSubunidades(Request $request)
    {
        $userSubUd = User::pluck('cod_subud')->toArray();
        return new SubUnidadCollectionResource(
            Subunidad::whereIn('cod_subud', $userSubUd)
                ->where('ud_subud', $request->cod_ud)
                ->get()
        );
    }

    public static function unidadId($id)
    {
        return Unidad::selectRaw('cod_ud, TRIM(nom_ud) as nom_ud')->where('cod_ud', $id)->first();
    }

    public static function subUnidadId($id)
    {
        return Subunidad::selectRaw('cod_subud, TRIM(nom_subud) as nom_subud')->where('cod_subud', $id)->first();
    }

    public static function getPersonalArma($numero, $tipo, $marca, $calibre)
    {
        $personalArma = PersonalArma::where([
            'nro_arma' => $numero,
            'cod_tipo_arma' => $tipo,
            'cod_marca' => $marca,
            'cod_calibre_principal' => $calibre
        ])
            ->orderBy('nro_ficha', 'DESC')
            ->first()->legajo;

        $query = Personal::select('nlegajo_ps','nombre_ps')->where('nlegajo_ps', $personalArma)->first();

        $funcionario = $query->nlegajo_ps.' - '.$query->nombre_ps;

        return $funcionario;
    }

    public static function getPersonalUdArma($numero, $tipo, $marca, $calibre)
    {
        $personalUdArma = Arma::where([
            'nro_arma' => $numero,
            'cod_tipo_arma' => $tipo,
            'cod_marca' => $marca,
            'cod_calibre_principal' => $calibre
        ])
            ->orderBy('nro_ficha', 'DESC')
            ->first()->ud_ar;

        return Unidad::selectRaw('cod_ud, TRIM(nom_ud) as nom_ud')->where('cod_ud', $personalUdArma)->first();
    }

    public function getPersonalNombre(Request $request)
    {
        $userCodUd = Auth('sanctum')->user()->cod_ud;

        $query = Personal::select(
            'nlegajo_ps',
            'nombre_ps',
            'nom_sestados',
            'desc_esc',
            'nom_ud',
            'nom_subud',
            'srevista_ps'
        )
            ->where('nombre_ps', 'LIKE', '%' . $request->nombre_ps . '%')
            ->where('srevista_ps', Personal::PERSONAL_ACTIVO)
            ->orderBy('nombre_ps');

        if ($userCodUd != Arma::UD_AR) {
            $query->where('ud_ps', $userCodUd);
        }

        $perPage = $request->input('per_page', 50);

        $results = $query->paginate($perPage);

        return new PersonalCollectionResource($results);
    }



    public function getPersonalHistorial(Request $request)
    {
        return new PersonalHistoricoArmaResource(Personal::where('nlegajo_ps', $request->nlegajo_ps)->first());
    }

    public static function getUdPersonalLegajo($legajo)
    {
        return Personal::selectRaw('ud_ps')->where('nlegajo_ps', $legajo)->first();
    }

    public function getPersonalNombreHistorial(Request $request)
    {
        return new PersonalCollectionResource(Personal::select(
            'nlegajo_ps',
            'nombre_ps',
            'nom_sestados',
            'desc_esc',
            'nom_ud',
            'nom_subud',
            'srevista_ps'
        )
            ->where('nombre_ps', 'LIKE', '%' . $request->nombre_ps . '%')
            ->paginate($request->offset ?? 5));
    }

    public function getPersonalArmaActual(Request $request)
    {
        return new PersonalArmaActualResource(Personal::where('nlegajo_ps', $request->nlegajo_ps)->first());
    }

    public function getGestionUsrPersonal(Request $request)
    {
        return new PersonalResource(Personal::where('nlegajo_ps', $request->nlegajo_ps)->first());
    }

    public function getGestionUsrPersonalNombre(Request $request)
    {
        $query = Personal::select(
            'nlegajo_ps',
            'nombre_ps',
            'nom_sestados',
            'desc_esc',
            'nom_ud',
            'nom_subud',
            'srevista_ps'
        )
            ->where('nombre_ps', 'LIKE', '%' . $request->nombre_ps . '%')
            ->where('srevista_ps', Personal::PERSONAL_ACTIVO)
            ->orderBy('nombre_ps');

        return new PersonalCollectionResource($query->get());
    }

    public function getConsultaPersonal(Request $request)
    {
        return new ConsultaPersonalResource(Personal::where('nlegajo_ps', $request->nlegajo_ps)->first());
    }
}
