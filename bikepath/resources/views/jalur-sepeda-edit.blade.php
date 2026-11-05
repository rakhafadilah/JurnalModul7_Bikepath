@extends('layouts.app')

@section('title', 'Edit Jalur - BikePath')

@section('content')
    <div class="box narrow" style="max-width: 640px;">
        <h1>Edit Jalur Sepeda</h1>
        <p class="sub">Kosongkan input foto jika tidak ingin mengganti foto.</p>

        <form method="POST" action="{{ route('jalur.update', $jalur) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <label for="nama">Nama Jalur</label>
            <input id="nama" type="text" name="nama" value="{{ old('nama', $jalur->nama) }}" required>

            <label for="kota">Kota</label>
            <input id="kota" type="text" name="kota" value="{{ old('kota', $jalur->kota) }}" required>

            <label for="titik_awal">Titik Awal</label>
            <input id="titik_awal" type="text" name="titik_awal" value="{{ old('titik_awal', $jalur->titik_awal) }}" required>

            <label for="titik_akhir">Titik Akhir</label>
            <input id="titik_akhir" type="text" name="titik_akhir" value="{{ old('titik_akhir', $jalur->titik_akhir) }}" required>

            <label for="jarak_km">Jarak (km)</label>
            <input id="jarak_km" type="number" step="0.01" min="0.1" name="jarak_km" value="{{ old('jarak_km', $jalur->jarak_km) }}" required>

            <label for="tingkat_kesulitan">Tingkat Kesulitan</label>
            <select id="tingkat_kesulitan" name="tingkat_kesulitan" required>
                @foreach (['Mudah', 'Sedang', 'Sulit'] as $t)
                    <option value="{{ $t }}" {{ old('tingkat_kesulitan', $jalur->tingkat_kesulitan) === $t ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
            </select>

            <label for="deskripsi">Deskripsi (opsional)</label>
            <textarea id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $jalur->deskripsi) }}</textarea>

            <label>Foto Saat Ini</label>
            @if ($jalur->foto)
                <img src="{{ asset('storage/' . $jalur->foto) }}" alt="{{ $jalur->nama }}"
                     style="max-width: 240px; border-radius: 10px; display: block;">
            @else
                <p class="muted" style="margin: 0;">Belum ada foto.</p>
            @endif

            <label for="foto">Ganti Foto (jpg, jpeg, png - maks. 2 MB)</label>
            <input id="foto" type="file" name="foto" accept="image/png,image/jpeg">
            @error('foto') <div class="field-error">{{ $message }}</div> @enderror

            <button type="submit" class="btn">Update</button>
            <a class="btn ghost" href="{{ route('jalur.index') }}">Batal</a>
        </form>
    </div>
@endsection