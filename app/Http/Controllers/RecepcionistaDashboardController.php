<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Especialidad;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RecepcionistaDashboardController extends Controller
{
    public function index()
    {
        $citasHoy = Cita::with(['paciente.user', 'medico.user', 'especialidad'])
            ->whereDate('fecha_hora', today())
            ->orderBy('fecha_hora')
            ->get();

        $totalPacientes     = Paciente::count();
        $citasPendientes    = Cita::where('estado', 'pendiente')->count();
        $medicosDisponibles = Medico::where('disponible', true)->count();

        return view('dashboards.recepcionista', compact(
            'citasHoy', 'totalPacientes', 'citasPendientes', 'medicosDisponibles'
        ));
    }

    // ── Citas ────────────────────────────────────────────────────────

    public function citas(Request $request)
    {
        $query = Cita::with(['paciente.user', 'medico.user', 'especialidad']);

        if ($request->filled('fecha')) {
            $query->whereDate('fecha_hora', $request->fecha);
        }
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        if ($request->filled('medico_id')) {
            $query->where('medico_id', $request->medico_id);
        }

        $citas   = $query->orderBy('fecha_hora')->paginate(20);
        $medicos = Medico::with('user')->where('disponible', true)->get();

        return view('recepcionista.citas.index', compact('citas', 'medicos'));
    }

    public function crearCita()
    {
        $especialidades = Especialidad::where('activa', true)->orderBy('nombre')->get();
        $pacientes      = Paciente::with('user')->orderBy('id', 'desc')->get();

        return view('recepcionista.citas.crear', compact('especialidades', 'pacientes'));
    }

    public function guardarCita(Request $request)
    {
        $request->validate([
            'paciente_id'     => 'required|exists:pacientes,id',
            'especialidad_id' => 'required|exists:especialidads,id',
            'medico_id'       => 'required|exists:medicos,id',
            'fecha_hora'      => 'required|date|after:now',
            'motivo'          => 'required|string|max:500',
        ], [
            'paciente_id.required'     => 'Seleccioná un paciente.',
            'especialidad_id.required' => 'Seleccioná una especialidad.',
            'medico_id.required'       => 'Seleccioná un médico.',
            'fecha_hora.required'      => 'Indicá la fecha y hora.',
            'fecha_hora.after'         => 'La cita debe ser en una fecha futura.',
            'motivo.required'          => 'El motivo de consulta es obligatorio.',
        ]);

        // Conflicto: médico ya tiene cita en esa hora exacta
        $conflictoMedico = Cita::where('medico_id', $request->medico_id)
            ->whereNotIn('estado', ['cancelada'])
            ->where('fecha_hora', $request->fecha_hora)
            ->exists();

        if ($conflictoMedico) {
            return back()
                ->withErrors(['fecha_hora' => 'El médico ya tiene una cita a esa hora. Elegí otro horario.'])
                ->withInput();
        }

        // Duplicado: ese paciente ya tiene cita a esa hora
        $duplicadoPaciente = Cita::where('paciente_id', $request->paciente_id)
            ->whereNotIn('estado', ['cancelada'])
            ->where('fecha_hora', $request->fecha_hora)
            ->exists();

        if ($duplicadoPaciente) {
            return back()
                ->withErrors(['fecha_hora' => 'El paciente ya tiene otra cita a esa hora.'])
                ->withInput();
        }

        Cita::create([
            'paciente_id'     => $request->paciente_id,
            'medico_id'       => $request->medico_id,
            'especialidad_id' => $request->especialidad_id,
            'fecha_hora'      => $request->fecha_hora,
            'motivo'          => $request->motivo,
            'estado'          => 'confirmada',
        ]);

        return redirect()->route('recepcionista.citas')->with('success', 'Cita agendada correctamente.');
    }

    public function reprogramarCita(Request $request, Cita $cita)
    {
        $request->validate([
            'fecha_hora' => 'required|date|after:now',
        ], [
            'fecha_hora.required' => 'Indicá la nueva fecha y hora.',
            'fecha_hora.after'    => 'La cita debe ser en una fecha futura.',
        ]);

        $conflicto = Cita::where('medico_id', $cita->medico_id)
            ->where('id', '!=', $cita->id)
            ->whereNotIn('estado', ['cancelada'])
            ->where('fecha_hora', $request->fecha_hora)
            ->exists();

        if ($conflicto) {
            return back()->withErrors(['fecha_hora' => 'El médico ya tiene una cita a esa hora. Elegí otro horario.']);
        }

        $cita->update(['fecha_hora' => $request->fecha_hora, 'estado' => 'confirmada']);

        return back()->with('success', 'Cita reprogramada correctamente.');
    }

    public function cancelarCita(Cita $cita)
    {
        if ($cita->estado === 'completada') {
            return back()->withErrors(['error' => 'No se puede cancelar una cita ya completada.']);
        }
        $cita->update(['estado' => 'cancelada']);
        return back()->with('success', 'Cita cancelada.');
    }

    // ── Pacientes ────────────────────────────────────────────────────

    public function crearPaciente()
    {
        return view('recepcionista.pacientes.crear');
    }

    public function guardarPaciente(Request $request)
    {
        $request->validate([
            'name'                 => 'required|string|max:255',
            'email'                => 'required|email|unique:users,email',
            'password'             => 'required|min:8|confirmed',
            'fecha_nacimiento'     => 'required|date|before:today',
            'genero'               => 'required|in:masculino,femenino,otro',
            'telefono'             => 'nullable|string|max:20',
            'direccion'            => 'nullable|string|max:255',
            'tipo_sangre'          => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'alergias'             => 'nullable|string|max:500',
            'enfermedades_previas' => 'nullable|string|max:500',
        ], [
            'name.required'             => 'El nombre es obligatorio.',
            'email.required'            => 'El correo es obligatorio.',
            'email.unique'              => 'Este correo ya está registrado.',
            'password.min'              => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed'        => 'Las contraseñas no coinciden.',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_nacimiento.before'   => 'La fecha debe ser anterior a hoy.',
            'genero.required'           => 'El género es obligatorio.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'rol'      => 'paciente',
        ]);

        Paciente::create([
            'user_id'              => $user->id,
            'fecha_nacimiento'     => $request->fecha_nacimiento,
            'genero'               => $request->genero,
            'telefono'             => $request->telefono,
            'direccion'            => $request->direccion,
            'tipo_sangre'          => $request->tipo_sangre,
            'alergias'             => $request->alergias,
            'enfermedades_previas' => $request->enfermedades_previas,
        ]);

        return redirect()->route('recepcionista.citas.crear')
            ->with('success', 'Paciente registrado. Ya podés agendar su cita.');
    }
}
