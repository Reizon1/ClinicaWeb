<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paciente;
use App\Models\Pago;
use Illuminate\Http\Request;

class AdminPaymentController extends Controller
{
    /**
     * Shared pending-payments dashboard for admin AND recepcionista.
     */
    public function index(Request $request)
    {
        $query = Pago::with(['paciente.user', 'cita.especialidad', 'cita.medico.user'])
            ->orderByRaw("FIELD(estado, 'pendiente', 'aprobado', 'rechazado', 'completado', 'fallido', 'reembolsado')")
            ->orderByDesc('created_at');

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('metodo_pago')) {
            $query->where('metodo_pago', $request->metodo_pago);
        }

        if ($request->filled('buscar')) {
            $b = '%' . $request->buscar . '%';
            $query->whereHas('paciente.user', fn($q) => $q->where('name', 'like', $b));
        }

        $pagos = $query->paginate(25)->withQueryString();

        $totalPendiente  = Pago::where('estado', 'pendiente')->count();
        $totalAprobado   = Pago::whereIn('estado', ['aprobado', 'completado'])->count();
        $totalRechazado  = Pago::whereIn('estado', ['rechazado', 'fallido'])->count();

        return view('admin.pagos.index', compact(
            'pagos', 'totalPendiente', 'totalAprobado', 'totalRechazado'
        ));
    }

    /**
     * Approve or reject a payment. Accessible to both admin and recepcionista.
     */
    public function updateStatus(Request $request, Pago $pago)
    {
        $request->validate([
            'accion' => 'required|in:aprobado,rechazado',
        ]);

        $pago->update([
            'estado'     => $request->accion,
            'fecha_pago' => $request->accion === 'aprobado' ? now() : $pago->fecha_pago,
        ]);

        $label = $request->accion === 'aprobado' ? 'aprobado' : 'rechazado';

        return back()->with('success', "Pago #{$pago->numero_factura} {$label} correctamente.");
    }
}
