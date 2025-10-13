<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Models\Medicos;
use App\Models\Pacientes;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user(); 

        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        // Determine role name based on model type or explicit role field
        $resolvedRole = null;
        if ($user instanceof User) {
            $resolvedRole = $user->role; // e.g. 'admin'
        } elseif ($user instanceof Medicos) {
            $resolvedRole = 'medico';
        } elseif ($user instanceof Pacientes) {
            $resolvedRole = 'paciente';
        }

        if (!$resolvedRole || !in_array($resolvedRole, $roles)) {
            return response()->json(['error' => 'Rol no autorizado'], 403);
        }

        return $next($request);
    }

}
