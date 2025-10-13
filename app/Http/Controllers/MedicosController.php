<?php

namespace App\Http\Controllers;

use App\Models\Medicos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicosController extends Controller
{
    public function index(){
        $medicos = Medicos::with(['especialidades:id,nombre_e','consultorio:id,numero,ubicacion'])
            ->select('id','especialidad_id','consultorio_id','nombre_m','apellido_m','edad','telefono','email')
            ->get();

        return response()->json($medicos);
    }




    public function store(Request $request){
        $validador = Validator::make($request->all(),[
            'especialidad_id' => 'required|integer|exists:especialidades,id',
            'consultorio_id' => 'required|integer|exists:consultorios,id',
            'nombre_m' => 'required|string|max:255',
            'apellido_m' => 'required|string|max:255',
            'edad' => 'required|integer|min:0',
            'telefono' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:medicos,email',
            'password' => 'required|string|min:8',
        ]);

        if ($validador->fails()) {
            return response()->json($validador->errors(), 422);
        }

        $medico = \App\Models\Medicos::create([
            'especialidad_id' => $request->especialidad_id,
            'nombre_m' => $request->nombre_m,
            'apellido_m' => $request->apellido_m,
            'edad' => (int) $request->edad,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'consultorio_id' => $request->consultorio_id,
            'password' => $request->password,
        ]);
        
        return response()->json($medico, 201);
    }




    public function show(string $id){
    $medico = Medicos::with(['especialidades:id,nombre_e','consultorio:id,numero,ubicacion'])->find($id);
        
        if (!$medico) {
            return response()->json(['message' => 'Medico no encontrado'], 404);
        }

        return response()->json($medico);
    }




    public function update(Request $request, string $id){

        $medico = Medicos::find($id);

        if (!$medico) {
            return response()->json(['message' => 'Medico no encontrada'], 404);
        }

        $validador = Validator::make($request->all(), [
            'especialidad_id' => 'integer|exists:especialidades,id',
            'consultorio_id' => 'integer|exists:consultorios,id',
            'nombre_m' => 'string|max:255',
            'apellido_m' => 'string|max:255',
            'edad' => 'integer|min:0',
            'telefono' => 'string|max:255',
            'email' => 'email|max:255|unique:medicos,email,' . $id,
            'password' => 'string|min:8',
        ]);

        if ($validador->fails()) {
            return response()->json($validador->errors(), 422);
        }

        $medico->update($request->all());
        return response()->json($medico);
    }




    public function destroy(string $id){

        $medico = Medicos::find($id);

        if (!$medico) {
            return response()->json(['message' => 'Medico no encontrado'], 404);
        }

        $medico->delete();
        return response()->json(['message' => 'Medico eliminado correctamente']);
    }



    public function buscarPorEmail($email)
    {
        $medico = \App\Models\Medicos::where('email', $email)->first();

        if (!$medico) {
            return response()->json([
                'success' => false,
                'message' => 'Medico no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $medico
        ]);
    }
    

    public function actualizarPorEmail(Request $request, $email)
    {
        $medico = Medicos::where('email', $email)->first();

        if (!$medico) {
            return response()->json(['error' => 'Médico no encontrado'], 404);
        }

        $medico->update($request->all());

        return response()->json(['message' => 'Médico actualizado correctamente', 'medico' => $medico]);
    }


    public function listarMedicosSinCitas() {
        $medicos = Medicos::doesntHave('citas')->get();
        return response()->json($medicos);
    }

    public function listarMedicosPediatria() {
        $medicos = Medicos::whereHas('especialidades', function($query) {
            $query->where('nombre_e', 'Pediatria');
        })->get();

        return response()->json($medicos);
    }


}
