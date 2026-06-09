<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paciente;
use App\Models\SuscripcionPremium;
use Illuminate\Http\Request;

class SuscripcionAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = SuscripcionPremium::with('paciente.user');

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $suscripciones  = $query->orderByDesc('created_at')->paginate(20);
        $totalActivas   = SuscripcionPremium::where('estado', 'activa')->count();
        $totalVencidas  = SuscripcionPremium::where('estado', 'vencida')->count();
        $totalRecaudado = SuscripcionPremium::where('estado', 'activa')->sum('precio');

        return view('admin.suscripciones.index', compact(
            'suscripciones', 'totalActivas', 'totalVencidas', 'totalRecaudado'
        ));
    }

    public function create()
    {
        $pacientes = Paciente::with('user')->orderBy('id')->get();
        return view('admin.suscripciones.create', compact('pacientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id'  => 'required|exists:pacientes,id',
            'plan'         => 'required|string|max:50',
            'precio'       => 'required|numeric|min:1',
            'fecha_inicio' => 'required|date',
            'duracion_mes' => 'required|integer|min:1|max:24',
            'metodo_pago'  => 'required|in:paypal,stripe',
        ], [
            'paciente_id.required' => 'Seleccioná un paciente.',
            'precio.required'      => 'El precio es obligatorio.',
            'duracion_mes.required'=> 'Indicá la duración en meses.',
        ]);

        SuscripcionPremium::create([
            'paciente_id'      => $request->paciente_id,
            'plan'             => $request->plan,
            'precio'           => $request->precio,
            'fecha_inicio'     => $request->fecha_inicio,
            'fecha_vencimiento'=> now()->parse($request->fecha_inicio)->addMonths($request->duracion_mes),
            'estado'           => 'activa',
            'metodo_pago'      => $request->metodo_pago,
        ]);

        return redirect()->route('admin.suscripciones.index')
            ->with('success', 'Suscripción Premium creada correctamente.');
    }

    public function destroy(SuscripcionPremium $suscripcion)
    {
        $suscripcion->update(['estado' => 'cancelada']);
        return back()->with('success', 'Suscripción cancelada.');
    }
}
