@extends('layouts.app')

@section('title', 'Detail Jalur - BikePath')

@section('content')
    <div class="box narrow" style="max-width: 640px;">
        <h1>{{ $jalur->nama }}</h1>
        <p class="sub">📍 {{ $jalur->kota }}</p>

        @if ($jalur->foto)
            <img src="{{ asset('storage/' . $jalur->foto) }}" alt="{{ $jalur->nama }}"
                 style="width: 100%; max-height: 360px; object-fit: cover; border-radius: 12px; margin-bottom: 16px;">
        @else
            <p class="muted">Belum ada foto untuk jalur ini.</p>
        @endif

        <p>Rute: <b>{{ $jalur->titik_awal }}</b> → <b>{{ $jalur->titik_akhir }}</b></p>
        <p>Jarak: <b>{{ $jalur->jarak_km }} km</b></p>
        <p>Tingkat kesulitan: <b>{{ $jalur->tingkat_kesulitan }}</b></p>
        <p>Deskripsi: {{ $jalur->deskripsi ?? '-' }}</p>
        <p>Aktivitas tercatat: <b>{{ $jalur->aktivitas_count }}</b></p>
        <p class="muted">Ditambahkan {{ $jalur->created_at->format('d-m-Y H:i') }}</p>

        @auth
            <a class="btn warn" href="{{ route('jalur.edit', $jalur) }}">Edit</a>
            <form class="inline" method="POST" action="{{ route('jalur.destroy', $jalur) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn danger"
                        onclick="return confirm('Yakin ingin menghapus jalur ini?')">Hapus</button>
            </form>
        @endauth
        <a class="btn ghost" href="{{ route('jalur.index') }}">Kembali</a>
    </div>
@endsection