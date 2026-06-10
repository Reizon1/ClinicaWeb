<?php

use App\Http\Controllers\Admin\ConfiguracionAdminController;
use App\Http\Controllers\Admin\SuscripcionAdminController;
use App\Http\Controllers\Recepcionista\PagoController as RecepcionistaPagoController;
use App\Http\Controllers\Admin\EspecialidadAdminController;
use App\Http\Controllers\Admin\MedicoAdminController;
use App\Http\Controllers\Admin\ReporteAdminController;
use App\Http\Controllers\Admin\UsuarioAdminController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\HistorialClinicoController;
use App\Http\Controllers\HorarioMedicoController;
use App\Http\Controllers\MedicoDashboardController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\MedicoPerfilController;
use App\Http\Controllers\PacienteDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecepcionistaDashboardController;
use App\Http\Controllers\RecetaController;
use App\Models\Especialidad;
use Illuminate\Support\Facades\Route;

// ── Landing page ──────────────────────────────────────────────────────────────
Route::get('/', function () {
    $medicos = \App\Models\Medico::with(['user', 'especialidad'])
        ->where('disponible', true)
        ->get();
    return view('welcome', compact('medicos'));
});

// ── Buscador de médicos (público) ─────────────────────────────────────────────
Route::get('/medicos', [MedicoController::class, 'buscar'])->name('medicos.buscar');
Route::get('/medicos/por-especialidad', [MedicoController::class, 'porEspecialidad'])->name('medicos.por-especialidad');

// ── Especialidades (público) ──────────────────────────────────────────────────
Route::get('/especialidades', [EspecialidadController::class, 'index'])->name('especialidades.index');
Route::get('/especialidades/{especialidad}', [EspecialidadController::class, 'show'])->name('especialidades.show');

// ── /dashboard → redirige según rol ──────────────────────────────────────────
Route::get('/dashboard', function () {
    return match (auth()->user()->rol) {
        'admin'          => redirect()->route('dashboard.admin'),
        'medico'         => redirect()->route('dashboard.medico'),
        'recepcionista'  => redirect()->route('dashboard.recepcionista'),
        default          => redirect()->route('dashboard.paciente'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

// ── Dashboard Paciente ────────────────────────────────────────────────────────
Route::middleware(['auth', 'rol:paciente'])->group(function () {
    Route::get('/dashboard/paciente', [PacienteDashboardController::class, 'index'])
        ->name('dashboard.paciente');
    Route::get('/paciente/citas',    [PacienteDashboardController::class, 'misCitas'])->name('paciente.citas');
    Route::get('/paciente/historial',[PacienteDashboardController::class, 'historial'])->name('paciente.historial');
    Route::get('/paciente/recetas',  [PacienteDashboardController::class, 'misRecetas'])->name('paciente.recetas');
    Route::get('/paciente/pagos',    [PacienteDashboardController::class, 'misPagos'])->name('paciente.pagos');
    Route::get('/citas/crear', [CitaController::class, 'create'])->name('citas.crear');
    Route::post('/citas',      [CitaController::class, 'store'])->name('citas.store');
});

// ── Dashboard Médico ──────────────────────────────────────────────────────────
Route::middleware(['auth', 'rol:medico'])->group(function () {
    Route::get('/dashboard/medico', [MedicoDashboardController::class, 'index'])
        ->name('dashboard.medico');
    Route::get('/medico/agenda/semanal', [MedicoDashboardController::class, 'agendaSemanal'])
        ->name('medico.agenda.semanal');

    // Horarios del médico
    Route::get('/horarios',          [HorarioMedicoController::class, 'index'])->name('horarios.index');
    Route::get('/horarios/agregar',  [HorarioMedicoController::class, 'create'])->name('horarios.create');
    Route::post('/horarios',         [HorarioMedicoController::class, 'store'])->name('horarios.store');
    Route::delete('/horarios/{horario}', [HorarioMedicoController::class, 'destroy'])->name('horarios.destroy');

    // Historiales clínicos
    Route::get('/historiales',                       [HistorialClinicoController::class, 'index'])->name('historiales.index');
    Route::get('/historiales/nuevo',                 [HistorialClinicoController::class, 'create'])->name('historiales.create');
    Route::post('/historiales',                      [HistorialClinicoController::class, 'store'])->name('historiales.store');
    Route::get('/historiales/{historial}',           [HistorialClinicoController::class, 'show'])->name('historiales.show');
    Route::get('/historiales/{historial}/editar',    [HistorialClinicoController::class, 'edit'])->name('historiales.edit');
    Route::put('/historiales/{historial}',           [HistorialClinicoController::class, 'update'])->name('historiales.update');
    Route::delete('/historiales/{historial}',        [HistorialClinicoController::class, 'destroy'])->name('historiales.destroy');

    // Recetas médicas
    Route::get('/recetas',                  [RecetaController::class, 'index'])->name('recetas.index');
    Route::get('/recetas/nueva',            [RecetaController::class, 'create'])->name('recetas.create');
    Route::post('/recetas',                 [RecetaController::class, 'store'])->name('recetas.store');
    Route::get('/recetas/{receta}',         [RecetaController::class, 'show'])->name('recetas.show');
    Route::get('/recetas/{receta}/editar',  [RecetaController::class, 'edit'])->name('recetas.edit');
    Route::put('/recetas/{receta}',         [RecetaController::class, 'update'])->name('recetas.update');
    Route::delete('/recetas/{receta}',      [RecetaController::class, 'destroy'])->name('recetas.destroy');

    // Perfil del médico
    Route::get('/medico/perfil',   [MedicoPerfilController::class, 'index'])->name('medico.perfil');
    Route::put('/medico/perfil',   [MedicoPerfilController::class, 'update'])->name('medico.perfil.update');
});

// ── Dashboard Recepcionista ───────────────────────────────────────────────────
Route::middleware(['auth', 'rol:recepcionista'])->group(function () {
    Route::get('/dashboard/recepcionista', [RecepcionistaDashboardController::class, 'index'])
        ->name('dashboard.recepcionista');

    // Gestión de citas
    Route::get('/recepcionista/citas',                        [RecepcionistaDashboardController::class, 'citas'])->name('recepcionista.citas');
    Route::get('/recepcionista/citas/crear',                  [RecepcionistaDashboardController::class, 'crearCita'])->name('recepcionista.citas.crear');
    Route::post('/recepcionista/citas',                       [RecepcionistaDashboardController::class, 'guardarCita'])->name('recepcionista.citas.guardar');
    Route::patch('/recepcionista/citas/{cita}/reprogramar',   [RecepcionistaDashboardController::class, 'reprogramarCita'])->name('recepcionista.citas.reprogramar');
    Route::patch('/recepcionista/citas/{cita}/cancelar',      [RecepcionistaDashboardController::class, 'cancelarCita'])->name('recepcionista.citas.cancelar');

    // Registro de pacientes
    Route::get('/recepcionista/pacientes/crear',   [RecepcionistaDashboardController::class, 'crearPaciente'])->name('recepcionista.pacientes.crear');
    Route::post('/recepcionista/pacientes',        [RecepcionistaDashboardController::class, 'guardarPaciente'])->name('recepcionista.pacientes.guardar');

    // Pagos
    Route::get('/recepcionista/pagos',                   [RecepcionistaPagoController::class, 'index'])->name('recepcionista.pagos.index');
    Route::get('/recepcionista/pagos/crear/{cita}',      [RecepcionistaPagoController::class, 'create'])->name('recepcionista.pagos.crear');
    Route::post('/recepcionista/pagos',                  [RecepcionistaPagoController::class, 'store'])->name('recepcionista.pagos.store');
});

// ── Dashboard Administrador ───────────────────────────────────────────────────
Route::middleware(['auth', 'rol:admin'])->group(function () {
    Route::get('/dashboard/admin', [AdminDashboardController::class, 'index'])
        ->name('dashboard.admin');

    // CRUD Médicos
    Route::get('/admin/medicos',                    [MedicoAdminController::class, 'index'])->name('admin.medicos.index');
    Route::get('/admin/medicos/crear',              [MedicoAdminController::class, 'create'])->name('admin.medicos.create');
    Route::post('/admin/medicos',                   [MedicoAdminController::class, 'store'])->name('admin.medicos.store');
    Route::get('/admin/medicos/{medico}',           [MedicoAdminController::class, 'show'])->name('admin.medicos.show');
    Route::get('/admin/medicos/{medico}/editar',    [MedicoAdminController::class, 'edit'])->name('admin.medicos.edit');
    Route::put('/admin/medicos/{medico}',           [MedicoAdminController::class, 'update'])->name('admin.medicos.update');
    Route::delete('/admin/medicos/{medico}',        [MedicoAdminController::class, 'destroy'])->name('admin.medicos.destroy');
    Route::post('/admin/medicos/{medico}/toggle',   [MedicoAdminController::class, 'toggle'])->name('admin.medicos.toggle');

    // CRUD Especialidades
    Route::get('/admin/especialidades',                        [EspecialidadAdminController::class, 'index'])->name('admin.especialidades.index');
    Route::get('/admin/especialidades/crear',                  [EspecialidadAdminController::class, 'create'])->name('admin.especialidades.create');
    Route::post('/admin/especialidades',                       [EspecialidadAdminController::class, 'store'])->name('admin.especialidades.store');
    Route::get('/admin/especialidades/{especialidad}/editar',  [EspecialidadAdminController::class, 'edit'])->name('admin.especialidades.edit');
    Route::put('/admin/especialidades/{especialidad}',         [EspecialidadAdminController::class, 'update'])->name('admin.especialidades.update');
    Route::delete('/admin/especialidades/{especialidad}',      [EspecialidadAdminController::class, 'destroy'])->name('admin.especialidades.destroy');
    Route::post('/admin/especialidades/{especialidad}/toggle', [EspecialidadAdminController::class, 'toggle'])->name('admin.especialidades.toggle');

    // Usuarios
    Route::get('/admin/usuarios',                        [UsuarioAdminController::class, 'index'])->name('admin.usuarios.index');
    Route::get('/admin/usuarios/crear',                  [UsuarioAdminController::class, 'create'])->name('admin.usuarios.create');
    Route::post('/admin/usuarios',                       [UsuarioAdminController::class, 'store'])->name('admin.usuarios.store');
    Route::get('/admin/usuarios/{usuario}',              [UsuarioAdminController::class, 'show'])->name('admin.usuarios.show');
    Route::get('/admin/usuarios/{usuario}/editar',       [UsuarioAdminController::class, 'edit'])->name('admin.usuarios.edit');
    Route::put('/admin/usuarios/{usuario}',              [UsuarioAdminController::class, 'update'])->name('admin.usuarios.update');
    Route::post('/admin/usuarios/{usuario}/rol',         [UsuarioAdminController::class, 'updateRol'])->name('admin.usuarios.rol');
    Route::delete('/admin/usuarios/{usuario}',           [UsuarioAdminController::class, 'destroy'])->name('admin.usuarios.destroy');

    // Reportes
    Route::get('/admin/reportes', [ReporteAdminController::class, 'index'])->name('admin.reportes.index');

    // Configuración
    Route::get('/admin/configuracion',  [ConfiguracionAdminController::class, 'index'])->name('admin.configuracion.index');
    Route::post('/admin/configuracion', [ConfiguracionAdminController::class, 'update'])->name('admin.configuracion.update');

    // Suscripciones Premium
    Route::get('/admin/suscripciones',          [SuscripcionAdminController::class, 'index'])->name('admin.suscripciones.index');
    Route::get('/admin/suscripciones/crear',    [SuscripcionAdminController::class, 'create'])->name('admin.suscripciones.create');
    Route::post('/admin/suscripciones',         [SuscripcionAdminController::class, 'store'])->name('admin.suscripciones.store');
    Route::delete('/admin/suscripciones/{suscripcion}', [SuscripcionAdminController::class, 'destroy'])->name('admin.suscripciones.destroy');
});

// ── Perfil (todos los usuarios autenticados) ──────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
