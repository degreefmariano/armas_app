<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Rol;
use App\Models\User;
use App\Models\Seccional;
use App\Models\UserCobol;
use Illuminate\Http\Request;
use App\Models\UnidadRegional;
use App\Models\Personal;
use App\Models\Unidad;
use App\Models\HistorialLogin;
use App\Models\Subunidad;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Models\AuditoriaGestionUsuario;
use App\Http\Responses\DataErrorResponse;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\getUserRequest;
use App\Http\Requests\Localidad\LocalidadRequest;
use App\Http\Requests\User\RolesUserRequest;
use App\Http\Requests\Password\ChangePasswordRequest;
use App\Http\Requests\Password\BlanquearPasswordRequest;
use App\Http\Requests\Personal\VerificarPersonalRequest;
use App\Http\Requests\Personal\ControlPersonalPDFRequest;
use App\Repositories\Contracts\UserInterface;

class UserController extends Controller
{
    protected $repository;

    public function __construct(UserInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        try {
            $user = $this->repository->index($request);
            return api()->ok('Total de usuarios devueltos exitosamente', $user);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        } 
    }

    public function getDptos()
    {
        try {
            $dptos = $this->repository->getDptos();
            return api()->ok('Total de departamentos devueltos exitosamente', $dptos);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        } 
    }

    public function getLocalidades(LocalidadRequest $request)
    {
        try {
            $localidades = $this->repository->getLocalidades($request);
            return api()->ok('Total de localidades devueltos exitosamente', $localidades);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        } 
    }

    public function updateUser(UpdateUserRequest $request)
    {
        try {
            $user = $this->repository->updateUser($request);
            return api()->ok('Datos del usuario modificados exitosamente', $user);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function store(StoreUserRequest $request)
    {
        try {
            $user = $this->repository->store($request);
            return api()->ok('Usuario guardado exitosamente', $user);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function generarUsuarios()
    {
        set_time_limit(360);
        try {
            $users = UserCobol::all();
            DB::table('users')->selectRaw("ALTER SEQUENCE users_id_seq restart 1");
            DB::beginTransaction();
            User::truncate();
            foreach ($users as $user) {
                $userModel                    = new User();
                $userModel->id                = $user->cod_usr; 
                $userModel->name              = $user->nom_usr;
                $userModel->email             = "USUARIO" . $user->cod_usr . config('constants.DOMINIO_MAIL_USERS');
                $userModel->password          = Hash::make(trim($user->clave_usr));
                $userModel->cod_ud            = $user->cod_ureg_usr;
                $userModel->legajo            = User::datosLegajo($userModel->id, $userModel->legajo);
                $userModel->cod_usr           = $user->cod_usr;
                $userModel->cod_subud         = $user->cod_secc_usr;
                $userModel->fecha_alta        = $user->fecha_alta_usr;
                $userModel->estado_usr        = $user->estado_usr;
                $userModel->estado_usr        = User::COD_ESTADO_USR;
                $userModel->rol               = User::COD_ROL;
                $userModel->personal_policial = User::COD_PERS_POL;
                $userModel->save(); 
            }
            DB::commit();

            $response = [
                'estado'  => 'success',
                'data'    => null,
                'message' => 'Proceso de usuarios exitoso'
            ];

            return response()->json($response);
        } catch (\Throwable $th) {
            DB::rollBack();
            $dataError = new DataErrorResponse($th, static::class);
            $response = ['estado' => 'error',
                'data' => $dataError,
                'message' => 'Ocurrio un error'];

            return response()->json($response);
        }
    }

    public function verificarPersonal(VerificarPersonalRequest $request)
    {
        try {
            $personal = $this->repository->getGestionUsrPersonal($request);
            return api()->ok('Resultado', $personal);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        } 
    }

    public function verificarPersonalOld(VerificarPersonalRequest $request)
    {
        try {
            $personalData =  $this->getPersonalPolicialporNi($request->legajo);
            if ($personalData) {
                $data = [
                    'nombre'      => trim($personalData->nombre_ps),
                    'documento'   => $personalData->ndoc_ps,
                    'legajo'      => $personalData->nlegajo_ps,
                    'jerarquia'   => trim($personalData->jerarquia),
                    'uregional'   => trim($personalData->unidades),
                    'seccion'     => trim($personalData->subunidades),
                    'iduregional' => $personalData->ud_ps,
                    'idseccion'   => $personalData->subud_ps
                ];

                // Buscar en el modelo User si tiene clave y si la cuenta está activa o inactiva
                $user = User::where('legajo', $request->legajo)->first();

                // Si el usuario existe, agregar propiedades adicionales al $data
                if ($user) {
                    $emailParts            = explode('@', $user->email);
                    $data['email']         = $emailParts[0];
                    $data['rol']           = strtoupper($user->Rol->nombre);
                    $data['estado_usr']    = $user->estado_usr;
                    $data['observaciones'] = trim(strtoupper($user->obs_usr)); 

                    // Si el usuario tiene cuenta activa
                    if ($user->estado_usr == 1) {
                        $response = [
                            'estado'  => 'succes',
                            'data'    => $data,
                            'estadoCuenta' => config('constants.ESTADO.CUENTA_ACTIVA'),
                            'message' => 'El Personal Policial tiene cuenta de usuario activa'
                        ];
                    } else {
                        $response = [
                            'estado'  => 'succes',
                            'data'    => $data,
                            'estadoCuenta' => config('constants.ESTADO.CUENTA_INACTIVA'),
                            'message' => 'El Personal Policial tiene cuenta de usuario inactiva'
                        ];
                    }
                } else {
                    $response = [
                        'estado'  => 'succes',
                        'data'    => $data,
                        'estadoCuenta' => config('constants.ESTADO.CUENTA_INEXISTENTE'),
                        'message' => 'El Personal Policial no tiene cuenta de usuario'
                    ];
                }

                return response()->json($response);
            }

            $response = [
                'estado'  => 'succes',
                'data'    => null,
                'estadoCuenta' => config('constants.ESTADO.PERSONAL_INEXISTENTE'),
                'message' => 'No se encontró el Personal Policial buscado'
            ];

            return response()->json($response);
        } catch (\Throwable $th) {
            $dataError = new DataErrorResponse($th, static::class);
            $response = [
                'estado' => 'error',
                'data' => $dataError,
                'message' => 'Ocurrio un error'
            ];

            return response()->json($response);
        }
    }

    public function cambiarPassword(ChangePasswordRequest $request)
    {
        try {
            $user = $this->repository->cambiarPassword($request);
            return api()->ok('Contraseña actualizada exitosamente', $user);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function blanquearPassword(BlanquearPasswordRequest $request)
    {
        try {
            $user = $this->repository->blanquearPassword($request);
            return api()->ok('Blanqueo de contraseña exitoso', $user);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }

    }

    public function updateObservaciones()
    {
        try {
            $observaciones = DB::table('observacion')
                ->select('nro_ficha_obs', 'nombre', 'id_obs')
                ->orderBy('id_obs')
                ->get();

            foreach ($observaciones as $obs) {
                DB::update(
                    "UPDATE vehiculo SET observaciones = concat(observaciones, '$obs->nombre' )
                    WHERE nro_ficha_sec = $obs->nro_ficha_obs");
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function createOrFindUnidadRegional($codRegional, $nombreRegional)
    {
        return UnidadRegional::firstOrCreate(
            ['cod_uregional' => $codRegional],
            ['nom_uregional' => $nombreRegional]
        );
    }

    public function createOrFindSeccional($codSeccional, $nombreSeccional,$codRegional)
    {

        return Seccional::firstOrCreate(
            ['cod_seccional' => $codSeccional],
            ['nombre' => $nombreSeccional,'ud_subud' => $codRegional],
        );
    }

    public function roles()
    {
        try {
            $rol = $this->repository->roles();
            return api()->ok('Roles devueltos exitosamente', $rol);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function estadosUsr()
    {
        try {
            $rol = $this->repository->estadosUsr();
            return api()->ok('Estados de usuarios devueltos exitosamente', $rol);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }

    public function getMiPerfil()
    {
        try {
            $user = auth('sanctum')->user();

            $usuario = User::select(
                'users.id',
                DB::raw("SPLIT_PART(users.email, '@', 1) as username"),
                'users.fecha_alta',
                'users.legajo',
                'users.documento' ,
                DB::raw('CASE WHEN users.estado_usr = 1 THEN \'ACTIVO\' ELSE \'INACTIVO\' END AS estado'),
                'users.name',
                'users.vencimiento',
                DB::raw('roles.nombre as rol'),
                'users.cod_ud',
                'users.cod_subud',
            )
            ->join('roles', 'users.rol', 'roles.id')
            ->where('personal_policial','true')
            ->orderBy('users.updated_at', 'desc')
            ->find($user->id);

            $nom_ud = Unidad::selectRaw('TRIM(nom_ud) as nom_ud')->where('cod_ud', $user->cod_ud)->first();
            $nom_subud = trim(Subunidad::where('cod_subud', $user->cod_subud)->first()->nom_subud);

            if ($usuario) {
                $usuario->legajo = !is_null($usuario->legajo) || !empty($usuario->legajo) ? $usuario->legajo : 'SIN DATOS';
                $usuario->documento = !is_null($usuario->documento) ||!empty($usuario->documento) ? $usuario->documento : 'SIN DATOS';
                $usuario->name = trim($usuario->name);
                $usuario->rol = strtoupper($usuario->rol);
                $usuario->cod_ud = !is_null($usuario->cod_ud) || !empty($usuario->cod_ud) ? trim($usuario->cod_ud) : 'SIN DATOS';
                $usuario->nom_ud = $nom_ud->nom_ud;
                $usuario->nom_subud = $nom_subud;
                $usuario->cod_subud = !is_null($usuario->cod_subud) || !empty($usuario->cod_subud) ? trim($usuario->cod_subud) : 'SIN DATOS';
            }
            
            $ultimaSesion = HistorialLogin::select('fecha_hora_login')->where('cod_usr', $user->id)->first();

            if ($ultimaSesion) {
                $ultimaSesion = Carbon::parse($ultimaSesion->fecha_hora_login)->format('d/m/Y H:i:s');
            } else {
                $ultimaSesion = 'SIN DATOS';
            }

            $usuario->ultimaSesion = $ultimaSesion;
            

            if (!$user) {
                $response = [
                    'estado' => 'error',
                    'data' => null,
                    'message' => 'Usuario no autenticado'
                ];
            } else {
                $response = [
                    'estado' => 'success',
                    'data' =>  $usuario,
                    'message' => 'Perfil del usuario obtenido exitosamente'
                ];
            }

            return response()->json($response);
        } catch (\Throwable $th) {
            $dataError = new DataErrorResponse($th, static::class);
            $response = [
                'estado' => 'error',
                'data' => $dataError,
                'message' => 'Ocurrio un error'
            ];

            return response()->json($response);
        }
    }

    public function getUser(getUserRequest $request)
    {
        try {
            $user = $this->repository->getUser($request);
            return api()->ok('Resultado', $user);
        } catch (\Throwable $th) {
            return api()->error('Error', $th->getMessage());
        }
    }
    
}
