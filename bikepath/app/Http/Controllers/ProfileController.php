<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Halaman Profile (?edit=1 menampilkan form edit)
    public function show(Request $request)
    {
        return view('profile', [
            'user'    => Auth::user(),
            'editing' => $request->boolean('edit'),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'full_name'     => ['nullable', 'string', 'max:255'],
            'bike_type'     => ['nullable', 'string', 'max:255'],
            'cycling_level' => ['required', 'in:beginner,intermediate,pro'],
            'address'       => ['nullable', 'string', 'max:500'],
        ]);

        Auth::user()->update($data);

        return redirect()->route('profile')->with('success', 'Profil berhasil disimpan.');
    }

    // Upload foto profil (tombol kamera)
    public function avatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // maks. 2 MB
        ]);

        $user = Auth::user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar); // hapus foto lama
        }

        $user->update([
            'avatar' => $request->file('avatar')->store('avatars', 'public'),
        ]);

        return redirect()->route('profile')->with('success', 'Foto profil berhasil diperbarui.');
    }
}
