<?php

namespace App\Http\Controllers;

use App\Models\Aktivitas;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AktivitasController extends Controller
{
    // Dipanggil dari halaman Map (fetch/JSON) saat tombol SAVE RIDE ditekan.
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'judul'           => ['required', 'string', 'max:255'],
            'jalur_sepeda_id' => ['required', 'exists:jalur_sepeda,id'],
            'durasi_menit'    => ['required', 'integer', 'min:1', 'max:1440'],
            'jarak_km'        => ['required', 'numeric', 'min:0.01', 'max:9999'],
            'catatan'         => ['nullable', 'string', 'max:1000'],
        ]);

        $data['user_id']        = Auth::id();
        $data['tanggal']        = now()->toDateString();
        $data['kecepatan_rata'] = round(min($data['jarak_km'] / ($data['durasi_menit'] / 60), 999.99), 2);

        Aktivitas::create($data);

        return response()->json(['status' => true, 'message' => 'Ride saved']);
    }
}
