<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Especialidad;
use App\Models\Medico;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MedicoAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Medico::with(['user', 'especialidad']);

        if ($request->filled('buscar')) {
            $b = $request->buscar;
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%$b%")
                ->orWhere('email', 'like', "%$b%"));
        }

        if ($request->filled('especialidad_id')) {
            $query->where('especialidad_id', $request->especialidad_id);
        }

        if ($request->has('disponible') && $request->disponible !== '') {
            $query->where('disponible', (bool) $request->disponible);
        }

        $medicos        = $query->paginate(15)->withQueryString();
        $especialidades = Especialidad::orderBy('nombre')->get();

        return view('admin.medicos.index', compact('medicos', 'especialidades'));
    }

    public function show(Medico $medico)
    {
        $medico->load(['user', 'especialidad', 'horarios']);

        $ultimasCitas = $medico->citas()
            ->with(['paciente.user', 'especialidad'])
            ->latest('fecha_hora')
            ->take(5)
            ->get();

        $totalCitas       = $medico->citas()->count();
        $citasCompletadas = $medico->citas()->where('estado', 'completada')->count();
        $citasPendientes  = $medico->citas()->whereIn('estado', ['pendiente', 'confirmada'])->count();

        return view('admin.medicos.show', compact(
            'medico', 'ultimasCitas', 'totalCitas', 'citasCompletadas', 'citasPendientes'
        ));
    }

    public function create()
    {
        $especialidades = Especialidad::where('activa', true)->orderBy('nombre')->get();
        return view('admin.medicos.create', compact('especialidades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => ['required', 'string', 'max:100', 'regex:/^[\pL\s\.\-\']+$/u'],
            'email'           => ['required', 'email', 'max:150', 'unique:users,email'],
            'password'        => ['required', 'min:8', 'confirmed'],
            'especialidad_id' => ['required', 'exists:especialidads,id'],
            'numero_licencia' => ['required', 'string', 'max:50', 'unique:medicos,numero_licencia', 'regex:/^[A-Za-z0-9\-]+$/'],
            'telefono'        => ['nullable', 'regex:/^[\d\+\-\(\)\s]+$/', 'max:20'],
            'descripcion'     => ['nullable', 'string', 'max:1000'],
        ], [
            'name.required'             => 'El nombre es obligatorio.',
            'name.regex'                => 'El nombre solo puede contener letras y espacios (sin números).',
            'name.max'                  => 'El nombre no puede superar los 100 caracteres.',
            'email.required'            => 'El correo electrónico es obligatorio.',
            'email.email'               => 'Ingresá un correo electrónico válido.',
            'email.unique'              => 'Este correo ya está registrado en el sistema.',
            'password.min'              => 'La contraseña debe tener mínimo 8 caracteres.',
            'password.confirmed'        => 'Las contraseñas no coinciden.',
            'especialidad_id.required'  => 'Debés seleccionar una especialidad.',
            'especialidad_id.exists'    => 'La especialidad seleccionada no existe.',
            'numero_licencia.required'  => 'El número de licencia es obligatorio.',
            'numero_licencia.unique'    => 'Este número de licencia ya está registrado.',
            'numero_licencia.regex'     => 'La licencia solo puede contener letras, números y guiones (ej: MP-10245).',
            'telefono.regex'            => 'El teléfono solo puede contener dígitos, +, - y paréntesis.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'rol'      => 'medico',
        ]);

        Medico::create([
            'user_id'         => $user->id,
            'especialidad_id' => $request->especialidad_id,
            'numero_licencia' => strtoupper($request->numero_licencia),
            'telefono'        => $request->telefono,
            'descripcion'     => $request->descripcion,
            'disponible'      => true,
        ]);

        return redirect()->route('admin.medicos.index')
            ->with('success', "Médico {$user->name} registrado correctamente.");
    }

    public function edit(Medico $medico)
    {
        $especialidades = Especialidad::where('activa', true)->orderBy('nombre')->get();
        $medico->load(['user', 'especialidad']);
        return view('admin.medicos.edit', compact('medico', 'especialidades'));
    }

    public function update(Request $request, Medico $medico)
    {
        $request->validate([
            'name'            => ['required', 'string', 'max:100', 'regex:/^[\pL\s\.\-\']+$/u'],
            'email'           => ['required', 'email', 'max:150', 'unique:users,email,' . $medico->user_id],
            'especialidad_id' => ['required', 'exists:especialidads,id'],
            'numero_licencia' => ['required', 'string', 'max:50', 'regex:/^[A-Za-z0-9\-]+$/', 'unique:medicos,numero_licencia,' . $medico->id],
            'telefono'        => ['nullable', 'regex:/^[\d\+\-\(\)\s]+$/', 'max:20'],
            'descripcion'     => ['nullable', 'string', 'max:1000'],
        ], [
            'name.required'            => 'El nombre es obligatorio.',
            'name.regex'               => 'El nombre solo puede contener letras y espacios (sin números).',
            'email.required'           => 'El correo electrónico es obligatorio.',
            'email.email'              => 'Ingresá un correo electrónico válido.',
            'email.unique'             => 'Este correo ya está en uso por otro usuario.',
            'especialidad_id.required' => 'Debés seleccionar una especialidad.',
            'numero_licencia.required' => 'El número de licencia es obligatorio.',
            'numero_licencia.unique'   => 'Este número de licencia ya está registrado por otro médico.',
            'numero_licencia.regex'    => 'La licencia solo puede contener letras, números y guiones (ej: MP-10245).',
            'telefono.regex'           => 'El teléfono solo puede contener dígitos, +, - y paréntesis.',
        ]);

        $medico->user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        $medico->update([
            'especialidad_id' => $request->especialidad_id,
            'numero_licencia' => strtoupper($request->numero_licencia),
            'telefono'        => $request->telefono,
            'descripcion'     => $request->descripcion,
            'disponible'      => $request->boolean('disponible'),
        ]);

        return redirect()->route('admin.medicos.index')
            ->with('success', "Médico {$medico->user->name} actualizado correctamente.");
    }

    public function toggle(Medico $medico)
    {
        $medico->update(['disponible' => !$medico->disponible]);
        $estado = $medico->disponible ? 'disponible' : 'inactivo';
        return back()->with('success', "Dr. {$medico->user->name} marcado como {$estado}.");
    }

    public function destroy(Medico $medico)
    {
        $nombre = $medico->user->name;
        $medico->user->delete();
        return redirect()->route('admin.medicos.index')
            ->with('success', "Médico {$nombre} eliminado del sistema.");
    }
}
