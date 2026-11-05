<?php

namespace App\Http\Controllers;

use App\Models\Aktivitas;
use App\Models\JalurSepeda;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    // Halaman Activity Hub: statistik + riwayat ride saya + daftar jalur sepeda
    public function index()
    {
        $userId = Auth::id();
        $mine   = Aktivitas::where('user_id', $userId);

        $totalRides = (clone $mine)->count();
        $totalKm    = (clone $mine)->sum('jarak_km');
        $totalMenit = (clone $mine)->sum('durasi_menit');

        $riwayat = Aktivitas::with('jalur')
            ->where('user_id', $userId)
            ->latest('tanggal')
            ->latest('id')
            ->take(5)
            ->get();

        $jalur = JalurSepeda::withCount('aktivitas')
            ->latest('id')
            ->paginate(6, ['*'], 'jalur_page')
            ->fragment('jalur');

        return view('activity', compact('totalRides', 'totalKm', 'totalMenit', 'riwayat', 'jalur'));
    }
}
