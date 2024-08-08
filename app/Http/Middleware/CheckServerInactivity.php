<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Http\Controllers\LoginController;

class CheckServerInactivity
{
    public function handle($request, Closure $next)
    {
        $user = auth('sanctum')->user();

        if ($user) {
            $lastActivity = $user->last_activity;

            if ($lastActivity && Carbon::now()->diffInMinutes($lastActivity) > config('auth.inactivity_timeout')) {
               
                (new LoginController())->logout();

                $response = [
                    'estado' => 'error',
                    'message' => 'Sesión expirada. Por favor, vuelva a ingresar.'
                ];
                return response()->json($response, 401);

            }
            // Actualiza last_activity para el usuario autenticado
            $user->last_activity = now();
            $user->save();
        }

        return $next($request);
    }
}