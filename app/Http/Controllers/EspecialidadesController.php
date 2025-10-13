<?php

namespace App\Http\Controllers;
use App\Models\Especialidades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class EspecialidadesController extends Controller
{
    public function index(){
        try {
            // Obtenemos solo los campos necesarios para el frontend
            $especialidades = Especialidades::select('id', 'nombre_e')->get();
            
            // Log para depuración
            Log::info('Especialidades encontradas: ' . $especialidades->count());
            
            // Si no hay especialidades, devolver un mensaje claro
            if ($especialidades->isEmpty()) {
                Log::warning('No se encontraron especialidades en la base de datos');
                return response()->json([], 200);
            }
            
            return response()->json($especialidades);
        } catch (\Exception $e) {
            Log::error('Error al obtener especialidades: ' . $e->getMessage());
            return response()->json(['message' => 'Error al obtener especialidades', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request){
        $validador = Validator::make($request->all(),[
            'nombre_e' => 'required|string|max:255|unique:especialidades,nombre_e',
        ]);

        if ($validador->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validador->errors()
            ], 422);
        }

        try {
            $especialidad = Especialidades::create($request->all());
            Log::info('Especialidad creada: ' . $especialidad->id);
            
            return response()->json([
                'message' => 'Especialidad creada correctamente',
                'data' => $especialidad
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al crear especialidad: ' . $e->getMessage());
            return response()->json(['message' => 'Error al crear especialidad', 'error' => $e->getMessage()], 500);
        }
    }

    public function show(string $id){
        try {
            $especialidad = Especialidades::find($id);
            
            if (!$especialidad) {
                return response()->json(['message' => 'Especialidad no encontrada'], 404);
            }

            return response()->json([
                'message' => 'Especialidad encontrada',
                'data' => $especialidad
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener especialidad #' . $id . ': ' . $e->getMessage());
            return response()->json(['message' => 'Error al obtener especialidad', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $id){
        try {
            $especialidad = Especialidades::find($id);

            if (!$especialidad) {
                return response()->json(['message' => 'Especialidad no encontrada'], 404);
            }

            $validador = Validator::make($request->all(), [
                'nombre_e' => 'required|string|max:255|unique:especialidades,nombre_e,' . $id,
            ]);

            if ($validador->fails()) {
                return response()->json([
                    'message' => 'Error de validación',
                    'errors' => $validador->errors()
                ], 422);
            }

            $especialidad->update($request->all());
            Log::info('Especialidad actualizada: ' . $id);
            
            return response()->json([
                'message' => 'Especialidad actualizada correctamente',
                'data' => $especialidad
            ]);
        } catch (\Exception $e) {
            Log::error('Error al actualizar especialidad #' . $id . ': ' . $e->getMessage());
            return response()->json(['message' => 'Error al actualizar especialidad', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy(string $id){
        try {
            $especialidad = Especialidades::find($id);

            if (!$especialidad) {
                return response()->json(['message' => 'Especialidad no encontrada'], 404);
            }

            // Verificar si hay médicos asociados
            if ($especialidad->medicos()->count() > 0) {
                return response()->json([
                    'message' => 'No se puede eliminar esta especialidad porque hay médicos asociados',
                    'medicos_count' => $especialidad->medicos()->count()
                ], 400);
            }

            $especialidad->delete();
            Log::info('Especialidad eliminada: ' . $id);
            
            return response()->json(['message' => 'Especialidad eliminada correctamente']);
        } catch (\Exception $e) {
            Log::error('Error al eliminar especialidad #' . $id . ': ' . $e->getMessage());
            return response()->json(['message' => 'Error al eliminar especialidad', 'error' => $e->getMessage()], 500);
        }
    }

    public function listarEspecialidadesPorLetraP() {
        try {
            $especialidades = Especialidades::where('nombre_e', 'LIKE', 'P%')->get();
            return response()->json([
                'message' => 'Especialidades encontradas',
                'data' => $especialidades
            ]);
        } catch (\Exception $e) {
            Log::error('Error al listar especialidades por letra P: ' . $e->getMessage());
            return response()->json(['message' => 'Error al obtener especialidades', 'error' => $e->getMessage()], 500);
        }
    }

    public function listarEspecialidadesConMasDe2Medicos() {
        try {
            $especialidades = Especialidades::has('medicos', '>=', 2)->get();
            return response()->json([
                'message' => 'Especialidades encontradas',
                'data' => $especialidades
            ]);
        } catch (\Exception $e) {
            Log::error('Error al listar especialidades con más de 2 médicos: ' . $e->getMessage());
            return response()->json(['message' => 'Error al obtener especialidades', 'error' => $e->getMessage()], 500);
        }
    }
}