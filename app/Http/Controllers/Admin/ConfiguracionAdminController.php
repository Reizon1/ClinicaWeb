<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfiguracionAdminController extends Controller
{
    public function index()
    {
        $config = [
            'clinica_nombre'    => session('cfg_nombre',    'Clínica Los Mollos'),
            'clinica_email'     => session('cfg_email',     'contacto@losmollos.com'),
            'clinica_telefono'  => session('cfg_telefono',  '+54 9 11 0000-0000'),
            'clinica_direccion' => session('cfg_direccion', 'Av. Principal 1234, Buenos Aires'),
            'clinica_horario'   => session('cfg_horario',   'Lunes a Viernes 08:00 – 18:00'),
            'max_citas_dia'     => session('cfg_max_citas', '20'),
            'tiempo_consulta'   => session('cfg_tiempo',    '30'),
        ];

        return view('admin.configuracion.index', compact('config'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'clinica_nombre'    => ['required', 'string', 'max:100'],
            'clinica_email'     => ['nullable', 'email', 'max:100'],
            'clinica_telefono'  => ['nullable', 'regex:/^[\d\+\-\(\)\s]+$/', 'max:30'],
            'clinica_direccion' => ['nullable', 'string', 'max:255'],
            'clinica_horario'   => ['nullable', 'string', 'max:100'],
            'max_citas_dia'     => ['nullable', 'integer', 'min:1', 'max:100'],
            'tiempo_consulta'   => ['nullable', 'integer', 'min:10', 'max:120'],
        ], [
            'clinica_nombre.required'  => 'El nombre de la clínica es obligatorio.',
            'clinica_email.email'      => 'Ingresá un correo válido.',
            'clinica_telefono.regex'   => 'El teléfono solo puede contener dígitos, +, - y paréntesis.',
            'max_citas_dia.integer'    => 'El máximo de citas debe ser un número entero.',
            'max_citas_dia.min'        => 'El mínimo de citas por día es 1.',
            'tiempo_consulta.integer'  => 'El tiempo de consulta debe ser un número entero.',
            'tiempo_consulta.min'      => 'El tiempo mínimo de consulta es 10 minutos.',
            'tiempo_consulta.max'      => 'El tiempo máximo de consulta es 120 minutos.',
        ]);

        // Persistir en sesión para demostración
        session([
            'cfg_nombre'    => $request->clinica_nombre,
            'cfg_email'     => $request->clinica_email,
            'cfg_telefono'  => $request->clinica_telefono,
            'cfg_direccion' => $request->clinica_direccion,
            'cfg_horario'   => $request->clinica_horario,
            'cfg_max_citas' => $request->max_citas_dia,
            'cfg_tiempo'    => $request->tiempo_consulta,
        ]);

        return back()->with('success', 'Configuración guardada correctamente.');
    }
}
