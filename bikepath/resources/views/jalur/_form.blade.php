@php $lv = old('tingkat_kesulitan', $jalur->tingkat_kesulitan ?? 'Mudah'); @endphp
<div class="form-row">
    <label>NAMA JALUR</label>
    <input type="text" name="nama" class="input-duo" value="{{ old('nama', $jalur->nama ?? '') }}" required>
    @error('nama')<div class="field-error">{{ $message }}</div>@enderror
</div>
<div class="form-row">
    <label>KOTA</label>
    <input type="text" name="kota" class="input-duo" value="{{ old('kota', $jalur->kota ?? '') }}" required>
    @error('kota')<div class="field-error">{{ $message }}</div>@enderror
</div>
<div class="form-grid-2">
    <div class="form-row">
        <label>TITIK AWAL</label>
        <input type="text" name="titik_awal" class="input-duo" value="{{ old('titik_awal', $jalur->titik_awal ?? '') }}" required>
        @error('titik_awal')<div class="field-error">{{ $message }}</div>@enderror
    </div>
    <div class="form-row">
        <label>TITIK AKHIR</label>
        <input type="text" name="titik_akhir" class="input-duo" value="{{ old('titik_akhir', $jalur->titik_akhir ?? '') }}" required>
        @error('titik_akhir')<div class="field-error">{{ $message }}</div>@enderror
    </div>
</div>
<div class="form-grid-2">
    <div class="form-row">
        <label>JARAK (KM)</label>
        <input type="number" step="0.01" name="jarak_km" class="input-duo" value="{{ old('jarak_km', $jalur->jarak_km ?? '') }}" required>
        @error('jarak_km')<div class="field-error">{{ $message }}</div>@enderror
    </div>
    <div class="form-row">
        <label>TINGKAT KESULITAN</label>
        <select name="tingkat_kesulitan" class="input-duo">
            @foreach(['Mudah','Sedang','Sulit'] as $o)
                <option value="{{ $o }}" @selected($lv === $o)>{{ $o }}</option>
            @endforeach
        </select>
        @error('tingkat_kesulitan')<div class="field-error">{{ $message }}</div>@enderror
    </div>
</div>
<div class="form-row">
    <label>DESKRIPSI</label>
    <textarea name="deskripsi" rows="4" class="input-duo">{{ old('deskripsi', $jalur->deskripsi ?? '') }}</textarea>
    @error('deskripsi')<div class="field-error">{{ $message }}</div>@enderror
</div>
<div class="form-row">
    <label>FOTO JALUR</label>
    @if(!empty($jalur?->foto))
        <img class="foto-now" src="{{ asset('storage/'.$jalur->foto) }}" alt="foto saat ini">
    @endif
    <input type="file" name="foto" accept=".jpg,.jpeg,.png" class="input-duo">
    <small>Format JPG/PNG, maksimal 2 MB.{{ !empty($jalur?->foto) ? ' Kosongkan jika tidak ingin mengganti.' : '' }}</small>
    @error('foto')<div class="field-error">{{ $message }}</div>@enderror
</div>
