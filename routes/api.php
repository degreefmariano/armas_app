<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ArmaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsoArmaController;
use App\Http\Controllers\CuibArmaController;
use App\Http\Controllers\TipoArmaController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\MarcaArmaController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\EstadoArmaController;
use App\Http\Controllers\CalibreArmaController;
use App\Http\Controllers\CambioUnidadPersonalController;
use App\Http\Controllers\EntregaArmaController;
use App\Http\Controllers\EstadisticaController;
use App\Http\Controllers\PersonalArmaController;
use App\Http\Controllers\ConsultaArmaController;
use App\Http\Controllers\ImportarArmaController;
use App\Http\Controllers\SituacionArmaController;
use App\Http\Controllers\CortaLargaArmaController;
use App\Http\Controllers\DevolucionArmaController;
use App\Http\Controllers\SubSituacionArmaController;
use App\Http\Controllers\MedidaCalibreArmaController;
use App\Http\Controllers\ReporteArmaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::put('/armas/generar/usuarios', [UserController::class, 'generarUsuarios']);

Route::post('/login', [LoginController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum', \App\Http\Middleware\CheckServerInactivity::class]], function () {

    Route::prefix('combos')->group(function () {
        Route::get('usos-arma', [UsoArmaController::class, 'getUsosArma']);
        Route::get('corta-larga-arma', [CortaLargaArmaController::class, 'getCortaLargaArma']);
        Route::get('medida-calibre-arma', [MedidaCalibreArmaController::class, 'getMedidaCalibreArma']);
    });

    Route::prefix('consultas')->group(function () {
        Route::get('unidades', [PersonalController::class, 'getUnidades']);
        Route::get('subunidades', [PersonalController::class, 'getSubunidades']);
        Route::get('subunidades-armas-asignadas', [PersonalController::class, 'getSubunidadesArmasAsignadas']);
        Route::get('users/subunidades', [PersonalController::class, 'getUsersSubunidades']);
        Route::get('personal', [PersonalController::class, 'getConsultaPersonal']);
        Route::prefix('armas')->group(function () {
            Route::get('armas-filtros', [ConsultaArmaController::class, 'getArmasFiltros']);
            Route::get('arma-clave', [ConsultaArmaController::class, 'getArmaClave']);
            Route::get('arma', [ArmaController::class, 'getArma']);
            Route::get('historial-arma', [ArmaController::class, 'getHistorialArma']);
            Route::get('armas-ud', [ArmaController::class, 'getArmasDepositoPorUd']);
            Route::get('armas-ud-devuelve', [ArmaController::class, 'getArmasUdDevuelve']);
            Route::get('armas-dependencia-a-ud-devuelve', [ArmaController::class, 'getArmasDependenciaAUdDevuelve']);
            Route::get('arma-clave-asignar', [ConsultaArmaController::class, 'getArmaClaveAsignar']);
        });
        Route::prefix('personal/asignar')->group(function () {
            Route::get('personal/legajo', [PersonalController::class, 'getPersonal']);
            Route::get('personal/nombre', [PersonalController::class, 'getPersonalNombre']);
        });
        Route::prefix('personal/devolucion')->group(function () {
            Route::get('personal/legajo', [PersonalController::class, 'getPersonalDevolucion']);
        });
        Route::prefix('historial')->group(function () {
            Route::get('historial-legajo/personal/armas', [PersonalController::class, 'getPersonalHistorial']);
            Route::get('historial-nombre/personal/armas', [PersonalController::class, 'getPersonalNombreHistorial']);
            Route::get('arma-actual/personal/armas', [PersonalController::class, 'getPersonalArmaActual']);
        });
        Route::prefix('entregas')->group(function () {
            Route::get('entregas', [EntregaArmaController::class, 'getEntregaArmaTipo']);
        });
        Route::prefix('devoluciones')->group(function () {
            Route::get('devoluciones', [DevolucionArmaController::class, 'getDevolucionArmaTipo']);
        });
        Route::prefix('cuibs')->group(function () {
            Route::get('cuibs', [CuibArmaController::class, 'getCuibsArma']);
        });
    });

    Route::prefix('abm')->group(function () {
        Route::prefix('tipos')->group(function () {
            Route::get('tipos-arma', [TipoArmaController::class, 'getTiposArma']);
            Route::post('tipo-arma', [TipoArmaController::class, 'createTipoArma']);
            Route::put('tipo-arma/{tipoArmaId}', [TipoArmaController::class, 'updateTipoArma']);
        });
        Route::prefix('marcas')->group(function () {
            Route::get('marcas-arma', [MarcaArmaController::class, 'getMarcasArma']);
            Route::post('marca-arma', [MarcaArmaController::class, 'createMarcaArma']);
            Route::put('marca-arma/{marcaArmaId}', [MarcaArmaController::class, 'updateMarcaArma']);
        });
        Route::prefix('calibres')->group(function () {
            Route::get('calibres-arma', [CalibreArmaController::class, 'getCalibresArma']);
            Route::post('calibre-arma', [CalibreArmaController::class, 'createCalibreArma']);
            Route::put('calibre-arma/{calibreArmaId}', [CalibreArmaController::class, 'updateCalibreArma']);
        });
        Route::prefix('situaciones')->group(function () {
            Route::get('situaciones-arma', [SituacionArmaController::class, 'getSituacionesArma']);
            Route::post('situacion-arma', [SituacionArmaController::class, 'createSituacionArma']);
            Route::put('situacion-arma/{situacionArmaId}', [SituacionArmaController::class, 'updateSituacionArma']);
        });
        Route::prefix('subsituaciones')->group(function () {
            Route::get('subsituaciones-arma', [SubSituacionArmaController::class, 'getSubSituacionesArma']);
        });
        Route::prefix('estados')->group(function () {
            Route::get('estados-arma', [EstadoArmaController::class, 'getEstadosArma']);
            Route::post('estado-arma', [EstadoArmaController::class, 'createEstadoArma']);
            Route::put('estado-arma/{estadoArmaId}', [EstadoArmaController::class, 'updateEstadoArma']);
        });
    });

    Route::prefix('arma')->group(function () {
        Route::post('arma', [ArmaController::class, 'createArma']);
        Route::put('arma/{ficha}', [ArmaController::class, 'updateArma']);
        Route::put('estado/arma/{ficha}', [ArmaController::class, 'updateEstadoArma']);
        Route::put('situacion/arma/{ficha}', [ArmaController::class, 'updateSituacionArma']);
    });

    Route::prefix('cuibs')->group(function () {
        Route::post('cuib', [CuibArmaController::class, 'createCuibArma']);
    });

    Route::prefix('impresiones')->group(function () {
        Route::get('pdf/arma', [PdfController::class, 'showArmaPdf']);
        Route::get('pdf/entrega/personal', [PdfController::class, 'entregaPersonalPdf']);
        Route::get('pdf/entrega/masiva', [PdfController::class, 'entregaMasivaPdf']);
        Route::get('pdf/devolucion/personal', [PdfController::class, 'devolucionPersonalPdf']);
        Route::get('pdf/devolucion/masiva', [PdfController::class, 'devolucionMasivaPdf']);
    });

    Route::prefix('asignaciones')->group(function () {
        Route::post('asignacion/personal/arma', [PersonalArmaController::class, 'asignarArmaPersonal']);
        Route::post('asignacion/masiva/arma', [EntregaArmaController::class, 'asignarArmaMasiva']);
        Route::post('asignacion/masiva/largas', [EntregaArmaController::class, 'asignarArmaMasivaLargas']);
    });

    Route::prefix('devoluciones')->group(function () {
        Route::post('devolucion/personal/arma', [PersonalArmaController::class, 'devolverArmaPersonal']);
        Route::post('especiales/personal/arma', [PersonalArmaController::class, 'devolucionEspecialArmaPersonal']);
        Route::post('devolucion/masiva/armas', [DevolucionArmaController::class, 'devolverArmasMasiva']);
    });

    Route::prefix('estadisticas')->group(function () {
        Route::get('deposito/ud', [EstadisticaController::class, 'getEstadisticaSubSituacionesArmaUd']);
        Route::get('situacion/ud', [EstadisticaController::class, 'getEstadisticaSituacionesArmaUd']);
        Route::get('corta-larga-arma/ud', [EstadisticaController::class, 'getEstadisticaCortaLargaArmaUd']);
        Route::get('servicio/gral', [EstadisticaController::class, 'getEstadisticaEnServicioArmaGral']);
        Route::get('servicio-larga-sub-ud/ud', [EstadisticaController::class, 'getEstadisticaEnServicioArmaLargaUd']);
        Route::get('deposito/gral', [EstadisticaController::class, 'getEstadisticaEnDepositoArmaGral']);
        Route::get('arma/gral', [EstadisticaController::class, 'getEstadisticaTotalArmaGral']);
    });

    Route::prefix('auditoria')->group(function () {
        Route::get('historial/login', [AuditoriaController::class, 'getHistorialLogin']);
        Route::get('historial/arma', [AuditoriaController::class, 'getHistorialArma']);
    });

    Route::prefix('cambio-unidad')->group(function () {
        Route::get('/', [CambioUnidadPersonalController::class, 'getPersonalCambioUnidad']);
        Route::put('/{ficha}', [CambioUnidadPersonalController::class, 'updatePersonalCambioUnidad']); 
    });

    Route::prefix('importar')->group(function () {
        Route::post('excel-armas/cortas', [ImportarArmaController::class, 'importarArmas']);
        Route::post('excel-armas/largas', [ImportarArmaController::class, 'importarArmasLargas']);
        Route::prefix('download')->group(function () {
            Route::get('template/armas-cortas', [ImportarArmaController::class, 'downloadTemplateCortas']);
            Route::get('template/armas-largas', [ImportarArmaController::class, 'downloadTemplateLargas']);
        });
        Route::get('/', [ImportarArmaController::class, 'listadoProcesos']);
        Route::get('/{jobId}', [ImportarArmaController::class, 'procesoPorId']);

        Route::get('download/excel/procesados-error/{jobId}', [ImportarArmaController::class, 'downloadExcel']);
    });

    Route::prefix('exportar')->group(function () {
        Route::get('reporte-armas', [ReporteArmaController::class, 'exportarReporteArmas']);
    });

    Route::prefix('descargar')->group(function () {
        Route::get('reporte-armas', [ReporteArmaController::class, 'descargarReporteArmas']);
    });
    
    Route::prefix('user')->group(function () {
        Route::get('/index', [UserController::class, 'index'])->middleware('can:isAdmin');
        Route::post('/store', [UserController::class, 'store'])->middleware('can:isAdmin');
        Route::put('/update', [UserController::class, 'updateUser'])->middleware('can:isAdmin');
        Route::get('/', [UserController::class, 'getUser'])->middleware('can:isAdmin');
        //Para revisión a futuro ep: user/verificarPersonal
        Route::get('/verificarPersonal', [UserController::class, 'verificarPersonal'])->middleware('can:isAdmin');
        Route::get('/nota/entrega/pdf', [PdfController::class, 'generarNotaEntregaPdfUser'])->middleware('can:isCarga');
        Route::post('/blanquearPassword', [UserController::class, 'blanquearPassword'])->middleware('can:isAdmin');
        Route::put('/cambiar/password', [UserController::class, 'cambiarPassword']);
        //Para revisión a futuro ep: user/perfil
        Route::get('/perfil', [UserController::class, 'getMiPerfil']);
        Route::get('/dptos', [UserController::class, 'getDptos']);
        Route::get('/localidades', [UserController::class, 'getLocalidades']);
        Route::get('/roles', [UserController::class, 'roles'])->middleware('can:isAdmin');
        Route::get('/estados', [UserController::class, 'estadosUsr'])->middleware('can:isAdmin');
    });

    Route::post('/logout', [LoginController::class, 'logout']);

    Route::prefix('gestion/usr/personal')->group(function () {
        Route::get('/', [PersonalController::class, 'getGestionUsrPersonal']);
        Route::get('/nombre', [PersonalController::class, 'getGestionUsrPersonalNombre']);
    });
});
