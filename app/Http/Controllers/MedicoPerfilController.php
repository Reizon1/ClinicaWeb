<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class MedicoPerfilController extends Controller
{
    public function index()
    {
        $user   = auth()->user();
        $medico = $user->medico->load(['especialidad', 'horarios', 'citas']);

        $totalCitas      = $medico->citas()->count();
        $citasCompletadas = $medico->citas()->where('estado', 'completada')->count();
        $totalHistoriales = $medico->citas()
            ->whereHas('historialClinico')
            ->count();

        return view('medico.perfil', compact('user', 'medico', 'totalCitas', 'citasCompletadas', 'totalHistoriales'));
    }

    public function update(Request $request)
    {
        $user   = auth()->user();
        $medico = $user->medico;

        $request->validate([
            'name'     => ['required', 'string', 'max:100', 'regex:/^[\pL\s\.\-\']+$/u'],
            'email'    => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($user->id)],
            'telefono' => ['nullable', 'regex:/^[\d\+\-\(\)\s]+$/', 'max:20'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.regex'    => 'El nombre solo puede contener letras y espacios.',
            'email.required'=> 'El correo es obligatorio.',
            'email.email'   => 'Ingresá un correo válido.',
            'email.unique'  => 'Este correo ya está en uso.',
            'telefono.regex'=> 'El teléfono solo puede contener números y símbolos + - ( ).',
            'password.min'  => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $user->update(['name' => $request->name, 'email' => $request->email]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        if ($request->filled('telefono')) {
            $medico->update(['telefono' => $request->telefono]);
        }

        return redirect()->route('medico.perfil')->with('success', 'Perfil actualizado correctamente.');
    }
}
