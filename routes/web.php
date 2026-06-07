<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\MedicoDashboardController;
use App\Http\Controllers\PacienteDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ── Landing page ──────────────────────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
});

// ── /dashboard → redirige al dashboard correcto según rol ─────────────────────
// El compañero que hace el login envía aquí a todos los usuarios después de entrar.
// Esta ruta lee el rol y los manda al lugar que les corresponde.
Route::get('/dashboard', function () {
    $rol = auth()->user()->rol;
    return match ($rol) {
        'admin'  => redirect()->route('dashboard.admin'),
        'medico' => redirect()->route('dashboard.medico'),
        default  => redirect()->route('dashboard.paciente'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

// ── Dashboard Paciente (solo rol: paciente) ───────────────────────────────────
Route::middleware(['auth', 'rol:paciente'])->group(function () {
    Route::get('/dashboard/paciente', [PacienteDashboardController::class, 'index'])
        ->name('dashboard.paciente');
});

// ── Dashboard Médico (solo rol: medico) ───────────────────────────────────────
Route::middleware(['auth', 'rol:medico'])->group(function () {
    Route::get('/dashboard/medico', [MedicoDashboardController::class, 'index'])
        ->name('dashboard.medico');
});

// ── Dashboard Administrador (solo rol: admin) ─────────────────────────────────
Route::middleware(['auth', 'rol:admin'])->group(function () {
    Route::get('/dashboard/admin', [AdminDashboardController::class, 'index'])
        ->name('dashboard.admin');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
