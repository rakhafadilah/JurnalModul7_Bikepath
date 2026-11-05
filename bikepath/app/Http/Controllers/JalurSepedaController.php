<?php

namespace App\Http\Controllers;

use App\Models\JalurSepeda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JalurSepedaController extends Controller
{

    public function create()
    {
        return view('jalur.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_jalur', 'public');
        }

        JalurSepeda::create($data);

        return redirect()->route('activity')->with('success', 'Jalur sepeda berhasil ditambahkan.');
    }

    public function show(JalurSepeda $jalur)
    {
        $jalur->loadCount('aktivitas');

        return view('jalur.show', compact('jalur'));
    }

    public function edit(JalurSepeda $jalur)
    {
        return view('jalur.edit', compact('jalur'));
    }

    public function update(Request $request, JalurSepeda $jalur)
    {
        $data = $request->validate($this->rules());

        if ($request->hasFile('foto')) {
            if ($jalur->foto) {
                Storage::disk('public')->delete($jalur->foto); 
            }
            $data['foto'] = $request->file('foto')->store('foto_jalur', 'public');
        }

        $jalur->update($data);

        return redirect()->route('activity')->with('success', 'Jalur sepeda berhasil diperbarui.');
    }

    public function destroy(JalurSepeda $jalur)
    {
        if ($jalur->foto) {
            Storage::disk('public')->delete($jalur->foto);
        }

        $jalur->delete(); 

        return redirect()->route('activity')->with('success', 'Jalur sepeda berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'nama'              => ['required', 'string', 'max:255'],
            'kota'              => ['required', 'string', 'max:255'],
            'titik_awal'        => ['required', 'string', 'max:255'],
            'titik_akhir'       => ['required', 'string', 'max:255'],
            'jarak_km'          => ['required', 'numeric', 'min:0.1', 'max:9999'],
            'tingkat_kesulitan' => ['required', 'in:Mudah,Sedang,Sulit'],
            'deskripsi'         => ['nullable', 'string'],
            'foto'              => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], 
        ];
    }
}
