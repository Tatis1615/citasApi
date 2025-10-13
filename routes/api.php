<?php

use App\Http\Controllers\CitasController;
use App\Http\Controllers\ConsultoriosController;
use App\Http\Controllers\EspecialidadesController;
use App\Http\Controllers\MedicosController; 
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('registrar', [AuthController::class, 'registrar']);
Route::post('login', [AuthController::class, 'login']);
Route::post('crearPaciente', [PacientesController::class, 'store']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => ['auth:sanctum']], function () {
    
    Route::get('me', [AuthController::class, 'me']);
    Route::put('perfil', [AuthController::class, 'updateMe']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::group(['middleware' => RoleMiddleware::class . ':admin'], function () {
        Route::get('listarAdmin', [AuthController::class, 'index']);
        Route::get('admin/{id}', [AuthController::class, 'show']);
        Route::post('crearMedico', [MedicosController::class, 'store']);
        Route::post('crearEspecialidad', [EspecialidadesController::class, 'store']);
        Route::post('crearConsultorio', [ConsultoriosController::class, 'store']);
        Route::get('listarPacientes', [PacientesController::class, 'index']);
        Route::delete('eliminarPaciente/{id}', [PacientesController::class, 'destroy']);
        Route::delete('eliminarMedico/{id}', [MedicosController::class, 'destroy']);
        Route::get('listarConsultorios', [ConsultoriosController::class, 'index']);
        Route::put('actualizarConsultorio/{id}', [ConsultoriosController::class, 'update']);
        Route::get('consultorios/{id}', [ConsultoriosController::class, 'show']);
        Route::get('especialidades/{id}', [EspecialidadesController::class, 'show']);
        Route::put('actualizarEspecialidad/{id}', [EspecialidadesController::class, 'update']);
        Route::get('pacientes/{id}', [PacientesController::class, 'show']);
        Route::get('medicos/{id}', [MedicosController::class, 'show']);
        Route::get('citas/{id}', [CitasController::class, 'show']);
        Route::put('actualizarPaciente/{id}', [PacientesController::class, 'update']);
        Route::put('actualizarMedico/{id}', [MedicosController::class, 'update']);
        Route::put('actualizarCita/{id}', [CitasController::class, 'update']);
        Route::delete('eliminarEspecialidad/{id}', [EspecialidadesController::class, 'destroy']);
        Route::delete('eliminarConsultorio/{id}', [ConsultoriosController::class, 'destroy']);
        Route::delete('eliminarCita/{id}', [CitasController::class, 'destroy']);
        Route::get('listarCitasMedico', [CitasController::class, 'listarCitasMedico']);
        Route::put('/editarUsuario/{id}', [AuthController::class, 'update']);
        Route::delete('eliminarAdmin/{id}', [AuthController::class, 'destroy']);
    });


    Route::middleware([RoleMiddleware::class . ':admin,paciente,medico'])->group(function () {
        Route::get('listarEspecialidades', [EspecialidadesController::class, 'index']);
        Route::get('especialidades', [EspecialidadesController::class, 'index']);
        Route::get('listarMedicos', [MedicosController::class, 'index']);
        Route::get('medicos', [MedicosController::class, 'index']);
        Route::get('listarConsultorios', [ConsultoriosController::class, 'index']);
        Route::get('listarCitas', [CitasController::class, 'index']);
        Route::post('crearCita', [CitasController::class, 'store']);
        Route::get('citas/{id}', [CitasController::class, 'show']);
        Route::get('medicos/{id}', [MedicosController::class, 'show']);
        Route::get('especialidades/{id}', [EspecialidadesController::class, 'show']);
        Route::get('listarCitasPaciente', [CitasController::class, 'listarCitasPaciente']);
        Route::delete('eliminarCita/{id}', [CitasController::class, 'destroy']);
        Route::get('listarPacientes', [PacientesController::class, 'index']);
        Route::put('actualizarPaciente/{id}', [PacientesController::class, 'update']);
        Route::get('pacientes/{id}', [PacientesController::class, 'show']);
        Route::get('listarCitasMedico', [CitasController::class, 'listarCitasMedico']);
        Route::put('actualizarCita/{id}', [CitasController::class, 'update']);
        Route::get('/pacientePorEmail/{email}', [PacientesController::class, 'buscarPorEmail']);
        Route::get('/medicoPorEmail/{email}', [MedicosController::class, 'buscarPorEmail']);
        Route::post('crearMedico', [MedicosController::class, 'store']);
        Route::put('/actualizarPacienteEmail/{email}', [PacientesController::class, 'actualizarPorEmail']);
        Route::put('/actualizarMedicoEmail/{email}', [MedicosController::class, 'actualizarPorEmail']);
    });
});

// Rutas comentadas se mantienen como referencia
// Route::get('listarEspecialidades', [EspecialidadesController::class, 'index']);
// Route::post('crearEspecialidad', [EspecialidadesController::class, 'store']);
// Route::get('especialidades/{id}', [EspecialidadesController::class, 'show']);
// Route::put('actualizarEspecialidad/{id}', [EspecialidadesController::class, 'update']);
// Route::delete('eliminarEspecialidad/{id}', [EspecialidadesController::class, 'destroy']);

// Route::get('listarConsultorios', [ConsultoriosController::class, 'index']);
// Route::post('crearConsultorio', [ConsultoriosController::class, 'store']);
// Route::get('consultorios/{id}', [ConsultoriosController::class, 'show']);
// Route::put('actualizarConsultorio/{id}', [ConsultoriosController::class, 'update']);
// Route::delete('eliminarConsultorio/{id}', [ConsultoriosController::class, 'destroy']);

// Route::get('listarPacientes', [PacientesController::class, 'index']);
// Route::post('crearPaciente', [PacientesController::class, 'store']);
// Route::get('pacientes/{id}', [PacientesController::class, 'show']);
// Route::put('actualizarPaciente/{id}', [PacientesController::class, 'update']);
// Route::delete('eliminarPaciente/{id}', [PacientesController::class, 'destroy']);

// Route::get('listarMedicos', [MedicosController::class, 'index']);
// Route::post('crearMedico', [MedicosController::class, 'store']);
// Route::get('medicos/{id}', [MedicosController::class, 'show']);
// Route::put('actualizarMedico/{id}', [MedicosController::class, 'update']);
// Route::delete('eliminarMedico/{id}', [MedicosController::class, 'destroy']);

// Route::get('listarCitas', [CitasController::class, 'index']);
// Route::post('crearCita', [CitasController::class, 'store']);
// Route::get('citas/{id}', [CitasController::class, 'show']);
// Route::put('actualizarCita/{id}', [CitasController::class, 'update']);
// Route::delete('eliminarCita/{id}', [CitasController::class, 'destroy']);

// Route::get('listarPacientesConCitasConfirmadas', [PacientesController::class, 'listarPacientesConCitasConfirmadas']);
// Route::get('listarPacientesPorLetraC', [PacientesController::class, 'listarPacientesPorLetraC']);
// Route::get('listarPacientesMayores60', [PacientesController::class, 'listarPacientesMayores60']);
// Route::get('listarPacientesSinCitas', [PacientesController::class, 'listarPacientesSinCitas']);

// Route::get('listarMedicosSinCitas', [MedicosController::class, 'listarMedicosSinCitas']);
// Route::get('listarMedicosPediatria', [MedicosController::class, 'listarMedicosPediatria']);

// Route::get('listarCitasPendientes', [CitasController::class, 'listarCitasPendientes']);
// Route::get('listarCitasDeHoy', [CitasController::class, 'listarCitasDeHoy']);

// Route::get('listarEspecialidadesPorLetraP', [EspecialidadesController::class, 'listarEspecialidadesPorLetraP']);
// Route::get('listarEspecialidadesConMasDe2Medicos', [EspecialidadesController::class, 'listarEspecialidadesConMasDe2Medicos']);