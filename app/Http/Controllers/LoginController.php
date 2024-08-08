<?php

namespace App\Http\Controllers;

use App\Jobs\AutoLogoutJob;
use Carbon\Carbon;
use App\Models\User;
use App\Models\HistorialLogin;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Responses\DataErrorResponse;
use Laravel\Sanctum\PersonalAccessToken;

class LoginController extends Controller
{

    public function login(LoginRequest $request)
    {
        try {
            $user  = $request->email;
            $email = strtoupper($user) . config('constants.DOMINIO_MAIL_USERS');

            if (!Auth::attempt(['email' => $email, 'password' => $request->password])) {
                return response()->json([
                    'estado'  => 'warning',
                    'message' => 'Credenciales incorrectas'
                ], 401);
            }

            $user = User::where('email', $email)
                ->where('estado_usr', 1)
                ->first();

            if (is_null($user)) {
                return response()->json([
                    'estado'  => 'warning',
                    'message' => 'Usuario inexistente o inactivo'
                ], 401);
            }

            $user->last_activity = Carbon::now()->format('Y-m-d H:i:s');
            $user->update();
            
            if (!$this->isSesionUnica($user)) {
                //Borra el token que estaba activo
                PersonalAccessToken::where('tokenable_id', $user->id)->delete();
                $ultimaSesion = HistorialLogin::where('cod_usr', $user->id)->orderBy('fecha_hora_login', 'desc')->first();

                if ($ultimaSesion) {
                    $fechaUltimaSesion = Carbon::parse($ultimaSesion->fecha_hora_login)->addMinutes(Carbon::now()->diffInMinutes($ultimaSesion->fecha_hora_login));
                    HistorialLogin::where('id', $ultimaSesion->id)->update(['fecha_hora_logout' => $fechaUltimaSesion]);
                }
            }

            //Crea un token nuevo
            $token = $user->createToken('auth_token')->plainTextToken;

            $fechaCaducidad = !empty($user->vencimiento) ? Carbon::createFromFormat('Y-m-d', $user->vencimiento) : null;
            $hoy = Carbon::now();
            $estadoCaducidad = $fechaCaducidad !== null && $fechaCaducidad <= $hoy;

            $response = [
                'estado'    => 'success',
                'data'      => $user,
                'fechaHora' => Carbon::now()->format('d-m-y H:i:s'),
                'token'     => $token,
                'vencido'   => $estadoCaducidad,
                'message'   => 'Usuario logueado con éxito'
            ];

            $this->setLoginHistorial($user, $request->ip());

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $dataError = new DataErrorResponse($th, static::class);
            $response = [
                'estado'  => 'error',
                'data'    => $dataError,
                'message' => 'Ocurrió un error inesperado'
            ];

            return response()->json($response, 500);
        }
    }

    public function logout()
    {
        try {
            $user = auth('sanctum')->user();
            
            $this->setLogoutHistorial($user);

            $user->tokens->each(function (PersonalAccessToken $token) {
                $token->delete(); // Elimina cada token asociado al usuario
            });

            $response = [
                'estado'  => 'succes',
                'message' => 'Usuario deslogueado con exito'
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

    public static function setLoginHistorial(User $user, $ipUser)
    {
        $historialLogin = new HistorialLogin();

        $historialLogin->cod_usr           = $user->id;
        $historialLogin->fecha_hora_login = Carbon::now();
        $historialLogin->ip               = $ipUser;
        $historialLogin->name             = $user->name;
        $historialLogin->email            = $user->email;

        $historialLogin->save();
    }

    public static function setLogoutHistorial($user)
    {
        $max = DB::select('select MAX(id) as id from historial_login where cod_usr = ' . $user->id);

        $historialLogout = HistorialLogin::where('id', $max[0]->id)
            ->first();

        $historialLogout->fecha_hora_logout = Carbon::now();

        $historialLogout->update();
    }

    private function isSesionUnica(User $user)
    {
        return $user->tokens->isEmpty();
    }

}