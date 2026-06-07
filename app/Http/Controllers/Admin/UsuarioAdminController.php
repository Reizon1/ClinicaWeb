<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsuarioAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = User::orderBy('created_at', 'desc');

        if ($request->filled('filtro_rol')) {
            $query->where('rol', $request->filtro_rol);
        }

        if ($request->filled('buscar')) {
            $b = '%' . $request->buscar . '%';
            $query->where(function ($q) use ($b) {
                $q->where('name', 'like', $b)
                  ->orWhere('email', 'like', $b);
            });
        }

        $usuarios = $query->paginate(20)->withQueryString();

        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('admin.usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:100', 'regex:/^[\pL\s\.\-\']+$/u'],
            'email'    => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'rol'      => ['required', 'in:admin,medico,paciente,recepcionista'],
        ], [
            'name.required'     => 'El nombre es obligatorio.',
            'name.regex'        => 'El nombre solo puede contener letras y espacios.',
            'email.required'    => 'El correo es obligatorio.',
            'email.email'       => 'Ingresá un correo válido.',
            'email.unique'      => 'Este correo ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min'      => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed'=> 'Las contraseñas no coinciden.',
            'rol.required'      => 'Debés seleccionar un rol.',
            'rol.in'            => 'El rol seleccionado no es válido.',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'rol'      => $request->rol,
        ]);

        return redirect()->route('admin.usuarios.index')
            ->with('success', "Usuario {$request->name} creado correctamente.");
    }

    public function show(User $usuario)
    {
        $usuario->load(['medico.especialidad', 'paciente']);
        return view('admin.usuarios.show', compact('usuario'));
    }

    public function edit(User $usuario)
    {
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:100', 'regex:/^[\pL\s\.\-\']+$/u'],
            'email'    => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($usuario->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'rol'      => ['required', 'in:admin,medico,paciente,recepcionista'],
        ], [
            'name.required'     => 'El nombre es obligatorio.',
            'name.regex'        => 'El nombre solo puede contener letras y espacios.',
            'email.required'    => 'El correo es obligatorio.',
            'email.email'       => 'Ingresá un correo válido.',
            'email.unique'      => 'Este correo ya está registrado por otro usuario.',
            'password.min'      => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed'=> 'Las contraseñas no coinciden.',
            'rol.required'      => 'Debés seleccionar un rol.',
            'rol.in'            => 'El rol seleccionado no es válido.',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'rol'   => $request->rol,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return redirect()->route('admin.usuarios.index')
            ->with('success', "Usuario {$usuario->name} actualizado correctamente.");
    }

    public function updateRol(Request $request, User $usuario)
    {
        abort_if($usuario->id === auth()->id(), 403, 'No puedes cambiar tu propio rol.');

        $request->validate([
            'rol' => ['required', 'in:admin,medico,paciente,recepcionista'],
        ], [
            'rol.required' => 'Debés seleccionar un rol.',
            'rol.in'       => 'El rol seleccionado no es válido.',
        ]);

        $usuario->update(['rol' => $request->rol]);

        return back()->with('success', "Rol de {$usuario->name} actualizado correctamente.");
    }

    public function destroy(User $usuario)
    {
        abort_if($usuario->id === auth()->id(), 403, 'No puedes eliminar tu propia cuenta.');

        $nombre = $usuario->name;
        $usuario->delete();

        return back()->with('success', "Usuario {$nombre} eliminado del sistema.");
    }
}
