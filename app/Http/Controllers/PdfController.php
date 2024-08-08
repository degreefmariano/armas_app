<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Arma;
use App\Models\User;
use App\Models\Unidad;
use App\Models\Entrega;
use App\Models\CuibArma;
use App\Models\VistaArma;
use App\Models\Subunidad;
use App\Models\Devolucion;
use Illuminate\Http\Request;
use App\Models\PersonalArma;
use App\Models\SituacionArma;
use App\Models\DetalleEntrega;
use App\Models\SubSituacionArma;
use App\Models\DetalleDevolucion;
use Illuminate\Support\Facades\DB;
use App\Models\CambioSituacionArma;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Repositories\PersonalRepository;
use App\Http\Requests\User\ControlPersonalPDFRequest;
use App\Http\Requests\Entrega\EntregaMasivaArmaPdfRequest;
use App\Http\Requests\Entrega\EntregaPersonalArmaPdfRequest;
use App\Http\Requests\Devolucion\DevolucionMasivaArmaPdfRequest;
use App\Http\Requests\Devolucion\DevolucionPersonalArmaPdfRequest;
use App\Models\CambioEstadoArma;
use App\Models\EstadoArma;
use App\Models\Historico;
use App\Models\Personal;

class PdfController extends Controller
{
    public function showArmaPdf(Request $request)
    {
        $marcaAgua = trim(Auth('sanctum')->user()->unidad->nom_ud);
        $fecha = Carbon::now()->format('d-m-Y H:i:s');
        $unidad = trim(Unidad::where('cod_ud', Auth('sanctum')->user()->cod_ud)->first()->nom_ud);
        $dependencia = trim(Subunidad::where('cod_subud', Auth('sanctum')->user()->cod_subud)->first()->nom_subud);

        //ANTES LO TOMABAMOS CON LA FICHA
        $arma = VistaArma::where('nro_ficha', $request->nro_ficha)->first();

        //AHORA LO TOMAMOS CON LOS DATOS DEL ARMA
        $vistaArma = new VistaArma();
        // $arma = $vistaArma->traeDatosArma($request->nro_arma, $request->cod_tipo_arma, $request->cod_marca, $request->calibre_principal);
        $unidadAr = Unidad::where('cod_ud', $arma->ud_ar)->first()->nom_ud;
        $funcionario = ($arma->situacion == SituacionArma::SERVICIO) ? trim(PersonalRepository::getPersonalArma($arma->nro_arma, $arma->cod_tipo_arma, $arma->cod_marca, $arma->cod_calibre_principal)) : null;
        $cuibs = CuibArma::cuibsArmaId($arma->nro_ficha);
        $deposito = ($arma->situacion == SituacionArma::DEPOSITO and !is_null($arma->sub_situacion)) ? ['subsituacion' => SubSituacionArma::subSituacionArmaDesc($arma->sub_situacion), 'trabajo_realizado' => CambioSituacionArma::getTrabajoRealizado($arma->nro_arma, $arma->cod_tipo_arma, $arma->cod_marca, $arma->cod_calibre_principal, $arma->situacion)] : null;
        $sustraccion_extravio = ($arma->situacion == SituacionArma::EXTRAVIADA or $arma->situacion == SituacionArma::SUSTRAIDA) ? CambioSituacionArma::getSustraccionExtravioSecuestro($arma->nro_arma, $arma->cod_tipo_arma, $arma->cod_marca, $arma->cod_calibre_principal, $arma->situacion) : null;
        $secuestro = ($arma->situacion == SituacionArma::SEC_JUD) ? CambioSituacionArma::getSecuestro($arma->nro_arma, $arma->cod_tipo_arma, $arma->cod_marca, $arma->cod_calibre_principal) : null;
        $historial_situaciones = CambioSituacionArma::getHistorialSituaciones($arma->nro_arma, $arma->cod_tipo_arma, $arma->cod_marca, $arma->cod_calibre_principal, $request->nro_ficha);
        $oficina_suboficina = '';
        $historial_estados = CambioEstadoArma::getEstadoHistorialArma($request);

        foreach ($historial_situaciones as $historial) {

            if ($historial->cod_situacion == SituacionArma::SERVICIO) {
                $personal = Personal::select('nombre_ps')->where('nlegajo_ps', $historial->funcionario)->first();

                if (!is_null($personal)) {
                    $historial->ud_funcionario = $historial->funcionario . " - " . $personal->nombre_ps;
                }
            }

            if ($historial->cod_situacion == SituacionArma::DEPOSITO || $historial->cod_situacion == SituacionArma::ALTA_EN_DEPOSITO) {
                $oficina = Unidad::select('nom_ud')->where('cod_ud', $historial->unidad)->first();
                $suboficina = Subunidad::select('nom_subud')->where('cod_subud', $historial->subunidad)->first();

                if (!is_null($oficina) && (!is_null($suboficina))) {
                    $historial->ud_unidad = $historial->unidad . " - " . $oficina->nom_ud;
                    $historial->ud_subunidad = $historial->subunidad . " - " . $oficina->nom_subud;
                    $oficina_suboficina = trim($oficina->nom_ud) . " - " . trim($suboficina->nom_subud);
                }
            }
        }

        $armaPdf = PDF::loadView('arma.showPdf', compact('marcaAgua', 'fecha', 'unidad', 'dependencia', 'arma', 'unidadAr', 'funcionario', 'cuibs', 'deposito', 'sustraccion_extravio', 'secuestro', 'historial_situaciones', 'historial_estados', 'oficina_suboficina'));
        return $armaPdf->stream('arma.pdf');
    }

    public function entregaPersonalPdf(EntregaPersonalArmaPdfRequest $request)
    {
        $marcaAgua = trim(Auth('sanctum')->user()->unidad->nom_ud);
        $entrega = Entrega::find($request->id_entrega);
        $detalle_entrega = DetalleEntrega::where('id_entrega', $entrega->id)->first();
        $arma = Arma::find($detalle_entrega->nro_ficha);

        $personalArma = null;
        if ($arma->situacion == Arma::SERVICIO) {
            $personalArma = PersonalArma::where([
                    'nro_arma'              => $arma->nro_arma,
                    'cod_tipo_arma'         => $arma->cod_tipo_arma,
                    'cod_marca'             => $arma->cod_marca,
                    'cod_calibre_principal' => $arma->cod_calibre_principal,
                    'legajo'                => $entrega->legajo_personal
                ])
                ->first();
        } else {
            $personalArma = Historico::where([
                    'nro_arma'              => $arma->nro_arma,
                    'cod_tipo_arma'         => $arma->cod_tipo_arma,
                    'cod_marca'             => $arma->cod_marca,
                    'cod_calibre_principal' => $arma->cod_calibre_principal,
                    'legajo'                => $entrega->legajo_personal
                ])
                ->first();
        }

        if ((!is_null($entrega) || !empty($entrega)) && (!is_null($detalle_entrega) && !empty($detalle_entrega)) && (!is_null($arma) || !empty($arma)) && (!is_null($personalArma) || !empty($personalArma))) {
            $dia = Carbon::parse($entrega->fecha_entrega)->format('d');
            $mes = Carbon::parse($entrega->fecha_entrega)->format('m');
            $anio = Carbon::parse($entrega->fecha_entrega)->format('Y');

            $meses = [
                'enero',
                'febrero',
                'marzo',
                'abril',
                'mayo',
                'junio',
                'julio',
                'agosto',
                'septiembre',
                'octubre',
                'noviembre',
                'diciembre'
            ];
            $nombre_mes_actual = $meses[$mes - 1];

            $entregaPersonalPdf = PDF::loadView('entregas.entregaArmaPersonalPdf', compact('marcaAgua', 'entrega', 'detalle_entrega', 'arma', 'dia', 'nombre_mes_actual', 'mes', 'anio', 'personalArma'));
            return $entregaPersonalPdf->stream('acta_entrega.pdf');
        } else {
            return api()->error('Error', 'Registro inexistente');
        }
    }

    public function generarNotaEntregaPdfUser(ControlPersonalPDFRequest $request)
    {
        try {
            $marcaAgua = trim(Auth('sanctum')->user()->unidad->nom_ud);
            $user = User::where('legajo', $request->legajo)->first();
            $unidad = Unidad::where('cod_ud', $user->cod_ud)->first();
            $subunidad = Subunidad::where('cod_subud', $user->cod_subud)->first();
            $legajo = $user->legajo;
            $email = $user->email;
            $nombre = $user->name;
            $unidad = $unidad->nom_ud;
            $subunidad = $subunidad->nom_subud;

            if ($request) {
                return PDF::loadView('usuario/notaEntregaUsuariopdf', [
                        'marcaAgua' => $marcaAgua,
                        'legajo' => $legajo,
                        'email' => $email,
                        'nombre' => $nombre,
                        'unidad' => $unidad,
                        'subunidad' => $subunidad
                    ])
                    ->setPaper('A4')
                    ->stream('nota_entrega_usuario.pdf');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $dataError = new DataErrorResponse($th, static::class);
            $response = [
                'estado' => 'error',
                'data' => $dataError,
                'message' => 'Ocurrio un error'
            ];

            return response()->json($response);
        }
    }

    public function entregaMasivaPdf(EntregaMasivaArmaPdfRequest $request)
    {
        $marcaAgua = trim(Auth('sanctum')->user()->unidad->nom_ud);
        $entrega = Entrega::find($request->id_entrega);
        $detalle_entrega = DetalleEntrega::where('id_entrega', $entrega->id)
            ->pluck('nro_ficha')
            ->toArray();
        $armas = Arma::whereIn('nro_ficha', $detalle_entrega)->get();
        $dia = Carbon::parse($entrega->fecha_entrega)->format('d');
        $mes = Carbon::parse($entrega->fecha_entrega)->format('m');
        $anio = Carbon::parse($entrega->fecha_entrega)->format('Y');

        $meses = [
            'enero',
            'febrero',
            'marzo',
            'abril',
            'mayo',
            'junio',
            'julio',
            'agosto',
            'septiembre',
            'octubre',
            'noviembre',
            'diciembre'
        ];
        $nombre_mes_actual = $meses[$mes - 1];

        $entregaMasivaPdf = PDF::loadView('entregas.entregaArmaMasivaPdf', compact('marcaAgua', 'entrega', 'detalle_entrega', 'armas', 'dia', 'nombre_mes_actual', 'mes', 'anio'));
        return $entregaMasivaPdf->stream($entrega->ud_entrega == Arma::UD_AR ? 'acta_entrega_unidad.pdf' : 'acta_entrega_dependencia.pdf');
    }

    public function devolucionPersonalPdf(DevolucionPersonalArmaPdfRequest $request)
    {
        $marcaAgua = trim(Auth('sanctum')->user()->unidad->nom_ud);
        $devolucion = Devolucion::find($request->id_devolucion);
        $detalle_devolucion = DetalleDevolucion::where('id_devolucion', $devolucion->id)->first();
        $arma = Arma::find($detalle_devolucion->nro_ficha);

        $dia = Carbon::parse($devolucion->fecha_devolucion)->format('d');
        $mes = Carbon::parse($devolucion->fecha_devolucion)->format('m');
        $anio = Carbon::parse($devolucion->fecha_devolucion)->format('Y');

        $meses = [
            'enero',
            'febrero',
            'marzo',
            'abril',
            'mayo',
            'junio',
            'julio',
            'agosto',
            'septiembre',
            'octubre',
            'noviembre',
            'diciembre'
        ];
        $nombre_mes_actual = $meses[$mes - 1];

        $devolucionPersonalPdf = PDF::loadView('devoluciones.devolucionArmaPersonalPdf', compact('marcaAgua', 'devolucion', 'detalle_devolucion', 'arma', 'dia', 'nombre_mes_actual', 'mes', 'anio'));
        return $devolucionPersonalPdf->stream('acta_devolucion.pdf');
    }

    public function devolucionMasivaPdf(DevolucionMasivaArmaPdfRequest $request)
    {dd($request);
        $marcaAgua = trim(Auth('sanctum')->user()->unidad->nom_ud);
        $devolucion = Devolucion::find($request->id_devolucion);
        $detalle_devolucion = DetalleDevolucion::where('id_devolucion', $devolucion->id)
            ->pluck('nro_ficha')
            ->toArray();
        $armas = Arma::whereIn('nro_ficha', $detalle_devolucion)->get();

        $dia = Carbon::parse($devolucion->fecha_entrega)->format('d');
        $mes = Carbon::parse($devolucion->fecha_entrega)->format('m');
        $anio = Carbon::parse($devolucion->fecha_entrega)->format('Y');

        $meses = [
            'enero',
            'febrero',
            'marzo',
            'abril',
            'mayo',
            'junio',
            'julio',
            'agosto',
            'septiembre',
            'octubre',
            'noviembre',
            'diciembre'
        ];
        $nombre_mes_actual = $meses[$mes - 1];

        $devolucionMasivaPdf = PDF::loadView('devoluciones.devolucionArmaMasivaPdf', compact('marcaAgua', 'devolucion', 'detalle_devolucion', 'armas', 'dia', 'nombre_mes_actual', 'mes', 'anio'));
        return $devolucionMasivaPdf->stream('acta_devolucion_masiva.pdf');
    }
}
