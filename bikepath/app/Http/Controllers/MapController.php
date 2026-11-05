<?php

namespace App\Http\Controllers;

use App\Models\JalurSepeda;

class MapController extends Controller
{
    // Halaman Map: peta + tracking ride. Daftar jalur dipakai pada form "Save Ride".
    public function index()
    {
        $jalur = JalurSepeda::orderBy('nama')->get(['id', 'nama']);

        return view('map', compact('jalur'));
    }
}
