<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QrConfigController extends Controller
{
    public function show()
    {
        $qrExists  = Storage::disk('public')->exists('config/qr_fijo.png');
        $qrImageUrl = $qrExists ? Storage::url('config/qr_fijo.png') : null;

        return view('admin.config.qr', compact('qrImageUrl'));
    }

    /**
     * Store or replace the static QR image.
     * Route is wrapped in rol:admin — recepcionistas are blocked at the route level.
     */
    public function store(Request $request)
    {
        $request->validate([
            'qr_imagen' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
        ], [
            'qr_imagen.required' => 'Selecciona una imagen para el código QR.',
            'qr_imagen.image'    => 'El archivo debe ser una imagen válida.',
            'qr_imagen.max'      => 'La imagen no puede superar 2 MB.',
        ]);

        // Ensure directory exists
        Storage::disk('public')->makeDirectory('config');

        // Overwrite the fixed QR file so the URL never changes
        $file    = $request->file('qr_imagen');
        $content = file_get_contents($file->getRealPath());
        Storage::disk('public')->put('config/qr_fijo.png', $content);

        // Also update session fallback used by legacy views
        session(['cfg_qr_imagen' => Storage::url('config/qr_fijo.png')]);

        return back()->with('success', 'Código QR actualizado correctamente.');
    }
}
