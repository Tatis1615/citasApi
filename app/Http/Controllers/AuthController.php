<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Medicos;
use App\Models\Pacientes;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function index(){
        $user = User::all();

        return response()->json($user);
    }

    public function show(string $id){
        $user = User::find($id);
        
        if (!$user) {
            return response()->json(['message' => 'Admin no encontrada'], 404);
        }

        return response()->json($user);
    }

    


    public function registrar(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,  
            'token' => $token,
            'token_type' => 'Bearer'
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $email = $request->email;
        $password = $request->password;

        $user = \App\Models\User::where('email', $email)->first();
        if ($user && \Hash::check($password, $user->password)) {
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'tipo' => 'user',
                    'name' => $user->name,
                ],
                'message' => 'Bienvenido Administrador',
            ]);
        }

        $medico = \App\Models\Medicos::where('email', $email)->first();
        if ($medico && \Hash::check($password, $medico->password)) {
            $token = $medico->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'user' => [
                    'id' => $medico->id,
                    'email' => $medico->email,
                    'tipo' => 'medico',
                    'name' => trim(($medico->nombre_m ?? '') . ' ' . ($medico->apellido_m ?? '')),
                ],
                'message' => 'Bienvenido Médico',
            ]);
        }

        $paciente = \App\Models\Pacientes::where('email', $email)->first();
        if ($paciente && \Hash::check($password, $paciente->password)) {
            $token = $paciente->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'user' => [
                    'id' => $paciente->id,
                    'email' => $paciente->email,
                    'tipo' => 'paciente',
                    'name' => trim(($paciente->nombre ?? '') . ' ' . ($paciente->apellido ?? '')),
                ],
                'message' => 'Bienvenido Paciente',
            ]);
        }

        return response()->json([
            'message' => 'Credenciales incorrectas'
        ], 401);
    }



    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Ha cerrado sesión correctamente y el token se ha eliminado correctamente.'
        ];
    }

    public function me(Request $request)
    {
        $authUser = Auth::user();

        $tipo = null;
        $name = null;

        if ($authUser instanceof User) {
            $tipo = 'user';
            $name = $authUser->name;
        } elseif ($authUser instanceof Medicos) {
            $tipo = 'medico';
            $name = trim(($authUser->nombre_m ?? '') . ' ' . ($authUser->apellido_m ?? ''));
        } elseif ($authUser instanceof Pacientes) {
            $tipo = 'paciente';
            $name = trim(($authUser->nombre ?? '') . ' ' . ($authUser->apellido ?? ''));
        }

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $authUser->id,
                'email' => $authUser->email,
                'tipo' => $tipo,
                'name' => $name,
            ],
        ], 200);
    }


    public function updateMe(Request $request)
    {
        $authUser = Auth::user();

        if ($authUser instanceof User) {
            $validator = \Validator::make($request->all(), [
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|max:255|unique:users,email,' . $authUser->id,
                'password' => 'sometimes|string|min:8',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $update = [];
            if ($request->filled('name')) $update['name'] = $request->name;
            if ($request->filled('email')) $update['email'] = $request->email;
            if ($request->filled('password')) $update['password'] = $request->password;
            $authUser->update($update);
            $name = $authUser->name;
            $tipo = 'user';
        } elseif ($authUser instanceof Medicos) {
            $validator = \Validator::make($request->all(), [
                'name' => 'sometimes|string|max:255',
                'nombre_m' => 'sometimes|string|max:255',
                'apellido_m' => 'sometimes|string|max:255',
                'edad' => 'sometimes|integer|min:0',
                'telefono' => 'sometimes|string|max:20',
                'email' => 'sometimes|email|max:255|unique:medicos,email,' . $authUser->id,
                'password' => 'sometimes|string|min:8',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $update = [];
            if ($request->filled('name')) {
                $parts = preg_split('/\s+/', trim($request->name), 2);
                $update['nombre_m'] = $parts[0] ?? $authUser->nombre_m;
                if (isset($parts[1])) $update['apellido_m'] = $parts[1];
            }
            if ($request->filled('nombre_m')) $update['nombre_m'] = $request->nombre_m;
            if ($request->filled('apellido_m')) $update['apellido_m'] = $request->apellido_m;
            if ($request->filled('edad')) $update['edad'] = $request->edad;
            if ($request->filled('telefono')) $update['telefono'] = $request->telefono;
            if ($request->filled('email')) $update['email'] = $request->email;
            if ($request->filled('password')) $update['password'] = $request->password;
            $authUser->update($update);
            $name = trim(($authUser->nombre_m ?? '') . ' ' . ($authUser->apellido_m ?? ''));
            $tipo = 'medico';
        } elseif ($authUser instanceof Pacientes) {
            $validator = \Validator::make($request->all(), [
                'name' => 'sometimes|string|max:255',
                'nombre' => 'sometimes|string|max:255',
                'apellido' => 'sometimes|string|max:255',
                'documento' => 'sometimes|string|max:50',
                'telefono' => 'sometimes|string|max:20',
                'direccion' => 'sometimes|string|max:255',
                'fecha_nacimiento' => 'sometimes|date',
                'email' => 'sometimes|email|max:255|unique:pacientes,email,' . $authUser->id,
                'password' => 'sometimes|string|min:8',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $update = [];
            if ($request->filled('name')) {
                $parts = preg_split('/\s+/', trim($request->name), 2);
                $update['nombre'] = $parts[0] ?? $authUser->nombre;
                if (isset($parts[1])) $update['apellido'] = $parts[1];
            }
            if ($request->filled('nombre')) $update['nombre'] = $request->nombre;
            if ($request->filled('apellido')) $update['apellido'] = $request->apellido;
            if ($request->filled('documento')) $update['documento'] = $request->documento;
            if ($request->filled('telefono')) $update['telefono'] = $request->telefono;
            if ($request->filled('direccion')) $update['direccion'] = $request->direccion;
            if ($request->filled('fecha_nacimiento')) $update['fecha_nacimiento'] = $request->fecha_nacimiento;
            if ($request->filled('email')) $update['email'] = $request->email;
            if ($request->filled('password')) $update['password'] = $request->password;
            $authUser->update($update);
            $name = trim(($authUser->nombre ?? '') . ' ' . ($authUser->apellido ?? ''));
            $tipo = 'paciente';
        } else {
            return response()->json(['error' => 'Tipo de usuario no soportado'], 400);
        }

        return response()->json([
            'message' => 'Perfil actualizado correctamente',
            'user' => [
                'id' => $authUser->id,
                'email' => $authUser->email,
                'tipo' => $tipo,
                'name' => $name,
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Admin no encontrado'], 404);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        return response()->json(['message' => 'Admin actualizado correctamente']);
    }

    public function destroy(string $id){

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Admin no encontrado'], 404);
        }

        $user->delete();
        return response()->json(['message' => 'Admin eliminado correctamente']);
    }

}
