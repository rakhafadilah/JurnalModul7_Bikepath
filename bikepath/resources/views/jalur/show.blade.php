@extends('layouts.app')
@section('title', $jalur->nama.' - BikePath')
@section('content')
<div class="form-page animate-slide-in">
    <div class="page-title"><x-icon name="map" :size="36" color="#00a8e8" /><h1>{{ $jalur->nama }}</h1></div>
    <div class="card-duo">
        @if($jalur->foto)
            <img class="jalur-foto" src="{{ asset('storage/'.$jalur->foto) }}" alt="{{ $jalur->nama }}">
            <a href="{{ asset('storage/'.$jalur->foto) }}" download class="btn-duo btn-secondary btn-sm" style="margin-bottom:22px;"><x-icon name="download" :size="16" /> UNDUH FOTO</a>
        @endif
        <div class="detail-grid">
            <div class="detail-item"><div class="d-icon"><x-icon name="map-pin" :size="20" color="#00a8e8" /></div><div><p class="d-label">KOTA</p><p class="d-value">{{ $jalur->kota }}</p></div></div>
            <div class="detail-item"><div class="d-icon"><x-icon name="route" :size="20" color="#8e2de2" /></div><div><p class="d-label">JARAK</p><p class="d-value">{{ number_format($jalur->jarak_km, 2) }} km</p></div></div>
            <div class="detail-item"><div class="d-icon"><x-icon name="mountain" :size="20" color="#fc6719" /></div><div><p class="d-label">KESULITAN</p><p class="d-value"><span class="lvl-badge {{ strtolower($jalur->tingkat_kesulitan) }}">{{ $jalur->tingkat_kesulitan }}</span></p></div></div>
            <div class="detail-item"><div class="d-icon"><x-icon name="play" :size="20" color="#00a8e8" /></div><div><p class="d-label">TITIK AWAL</p><p class="d-value">{{ $jalur->titik_awal }}</p></div></div>
            <div class="detail-item"><div class="d-icon"><x-icon name="flag" :size="20" color="#8e2de2" /></div><div><p class="d-label">TITIK AKHIR</p><p class="d-value">{{ $jalur->titik_akhir }}</p></div></div>
            <div class="detail-item"><div class="d-icon"><x-icon name="bike" :size="20" color="#fc6719" /></div><div><p class="d-label">DIPAKAI RIDE</p><p class="d-value">{{ $jalur->aktivitas_count }}x</p></div></div>
        </div>
        @if($jalur->deskripsi)
            <div class="activity-notes"><div class="notes-label"><x-icon name="file-text" :size="16" /> DESKRIPSI</div><p class="notes-text">{{ $jalur->deskripsi }}</p></div>
        @endif
        <div class="jalur-actions">
            <a href="{{ route('activity') }}#jalur" class="btn-duo btn-outline btn-sm">KEMBALI</a>
            <a href="{{ route('jalur.edit', $jalur) }}" class="btn-duo btn-secondary btn-sm">EDIT</a>
            <form action="{{ route('jalur.destroy', $jalur) }}" method="POST" onsubmit="return confirm('Hapus jalur ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-duo btn-danger btn-sm">HAPUS</button>
            </form>
        </div>
    </div>
</div>
@endsection
