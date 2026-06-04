<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de preview de diseño (sin auth — se protegerán al agregar la lógica)
Route::get('/preview/paciente', fn() => view('dashboards.paciente'))->name('preview.paciente');
Route::get('/preview/admin',    fn() => view('dashboards.admin'))->name('preview.admin');
Route::get('/preview/medico',   fn() => view('dashboards.medico'))->name('preview.medico');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
