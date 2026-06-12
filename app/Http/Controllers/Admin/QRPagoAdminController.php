<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QRPagoAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Pago::with(['paciente.user', 'cita.medico.user', 'cita.especialidad'])
            ->where('metodo_pago', 'qr');

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        } else {
            // Default: show pending first
            $query->orderByRaw("FIELD(estado, 'pendiente', 'completado', 'reembolsado', 'fallido')");
        }

        $pagos = $query->orderByDesc('created_at')->paginate(20);

        $pendientes  = Pago::where('metodo_pago', 'qr')->where('estado', 'pendiente')->count();
        $completados = Pago::where('metodo_pago', 'qr')->where('estado', 'completado')->count();
        $qrImageUrl  = session('cfg_qr_imagen', null);

        return view('admin.pagos.qr', compact('pagos', 'pendientes', 'completados', 'qrImageUrl'));
    }

    public function aprobar(Pago $pago)
    {
        abort_if($pago->metodo_pago !== 'qr', 422);

        $pago->update([
            'estado'     => 'completado',
            'fecha_pago' => now(),
        ]);

        return back()->with('success', "Pago #{$pago->numero_factura} aprobado correctamente.");
    }

    public function rechazar(Pago $pago)
    {
        abort_if($pago->metodo_pago !== 'qr', 422);

        $pago->update(['estado' => 'fallido']);

        return back()->with('success', "Pago #{$pago->numero_factura} rechazado.");
    }

    public function uploadQR(Request $request)
    {
        $request->validate([
            'qr_imagen' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
        ], [
            'qr_imagen.required' => 'Seleccioná una imagen para el QR.',
            'qr_imagen.image'    => 'El archivo debe ser una imagen.',
            'qr_imagen.max'      => 'La imagen no puede superar 2 MB.',
        ]);

        $path = $request->file('qr_imagen')->store('qr', 'public');
        session(['cfg_qr_imagen' => Storage::url($path)]);

        return back()->with('success', 'Código QR actualizado correctamente.');
    }
}
