<?php

namespace App\Http\Controllers;

use App\Models\Komunitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KomunitasController extends Controller
{
    // Halaman Community: sidebar daftar komunitas + panel chat / anggota (?g=ID&tab=chat|members)
    public function index(Request $request)
    {
        $user      = Auth::user();
        $groups    = Komunitas::orderBy('nama')->get();
        $memberIds = $user->komunitas()->pluck('komunitas.id')->all();

        $active = $request->filled('g') ? $groups->firstWhere('id', (int) $request->query('g')) : null;
        $tab    = $request->query('tab') === 'members' ? 'members' : 'chat';

        $messages = collect();
        $members  = collect();

        if ($active) {
            if ($tab === 'chat') {
                $messages = $active->pesan()->with('user')->latest('id')->take(50)->get()->reverse()->values();
            } else {
                $members = $active->anggota()->orderBy('name')->get();
            }
        }

        return view('community', compact('groups', 'memberIds', 'active', 'tab', 'messages', 'members'));
    }

    public function join(Komunitas $komunitas)
    {
        $user = Auth::user();

        if (! $user->komunitas()->where('komunitas.id', $komunitas->id)->exists()) {
            $user->komunitas()->attach($komunitas->id);
            $komunitas->increment('jumlah_anggota');
        }

        return back()->with('success', 'Kamu bergabung ke komunitas ' . $komunitas->nama . '.');
    }

    public function leave(Komunitas $komunitas)
    {
        $user = Auth::user();

        if ($user->komunitas()->where('komunitas.id', $komunitas->id)->exists()) {
            $user->komunitas()->detach($komunitas->id);
            if ($komunitas->jumlah_anggota > 0) {
                $komunitas->decrement('jumlah_anggota');
            }
        }

        return back()->with('success', 'Kamu keluar dari komunitas ' . $komunitas->nama . '.');
    }

    public function send(Request $request, Komunitas $komunitas)
    {
        $user = Auth::user();

        // Hanya anggota yang boleh ikut berdiskusi
        abort_unless($user->komunitas()->where('komunitas.id', $komunitas->id)->exists(), 403);

        $data = $request->validate([
            'pesan' => ['required', 'string', 'max:1000'],
        ]);

        $komunitas->pesan()->create([
            'user_id' => $user->id,
            'pesan'   => $data['pesan'],
        ]);

        return redirect()->route('community', ['g' => $komunitas->id]);
    }
}
