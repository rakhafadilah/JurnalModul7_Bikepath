@extends('layouts.app')
@section('title', 'Activity - BikePath')

@section('content')
<div class="activity-container animate-slide-in">
    <div class="page-title">
        <x-icon name="activity" :size="40" color="#00a8e8" />
        <h1>ACTIVITY HUB</h1>
    </div>

    <div class="stats-scroll-container">
        <div class="stats-row">
            <div class="card-duo stats-card">
                <div class="stats-header"><x-icon name="bike" :size="20" color="#00a8e8" /><span>TOTAL RIDES</span></div>
                <h2>{{ $totalRides }}</h2>
            </div>
            <div class="card-duo stats-card">
                <div class="stats-header"><x-icon name="route" :size="20" color="#8e2de2" /><span>TOTAL JARAK</span></div>
                <h2>{{ number_format($totalKm, 1) }} <small style="font-size:1rem;color:#00a8e8">KM</small></h2>
            </div>
            <div class="card-duo stats-card">
                <div class="stats-header"><x-icon name="clock" :size="20" color="#fc6719" /><span>TOTAL WAKTU</span></div>
                <h2>{{ floor($totalMenit / 60) }}<small style="font-size:1rem;color:#00a8e8">J</small> {{ $totalMenit % 60 }}<small style="font-size:1rem;color:#00a8e8">M</small></h2>
            </div>
        </div>
    </div>

    {{-- RIWAYAT RIDE --}}
    <div class="section-heading"><h2>RIWAYAT RIDE</h2></div>
    <div class="activity-list">
        @forelse($riwayat as $r)
            <details class="card-duo activity-card" style="padding:0;">
                <summary class="activity-header">
                    <div class="activity-lead">
                        <div class="activity-icon-box"><x-icon name="bike" :size="24" color="#fff" /></div>
                        <div>
                            <h3 class="activity-title">{{ $r->judul ?: 'Ride' }}</h3>
                            <div class="activity-date-box">
                                <x-icon name="calendar" :size="14" />
                                {{ \Illuminate\Support\Carbon::parse($r->tanggal)->translatedFormat('d M Y') }}
                                @if($r->jalur) · {{ $r->jalur->nama }} @endif
                            </div>
                        </div>
                    </div>
                    <div class="activity-main-stats">
                        <div class="mini-stat"><span class="val">{{ number_format($r->jarak_km, 2) }}</span><span class="unit">KM</span></div>
                        <span class="chev chev-closed"><x-icon name="chevron-down" :size="22" /></span>
                        <span class="chev chev-open"><x-icon name="chevron-up" :size="22" /></span>
                    </div>
                </summary>
                <div class="activity-detail-content">
                    <div class="detail-grid">
                        <div class="detail-item"><div class="d-icon"><x-icon name="clock" :size="20" color="#00a8e8" /></div>
                            <div><p class="d-label">DURASI</p><p class="d-value">{{ $r->durasi_menit }} menit</p></div></div>
                        <div class="detail-item"><div class="d-icon"><x-icon name="gauge" :size="20" color="#8e2de2" /></div>
                            <div><p class="d-label">KECEPATAN RATA-RATA</p><p class="d-value">{{ number_format($r->kecepatan_rata, 1) }} km/j</p></div></div>
                        <div class="detail-item"><div class="d-icon"><x-icon name="route" :size="20" color="#fc6719" /></div>
                            <div><p class="d-label">JARAK</p><p class="d-value">{{ number_format($r->jarak_km, 2) }} km</p></div></div>
                    </div>
                    @if($r->catatan)
                        <div class="activity-notes">
                            <div class="notes-label"><x-icon name="file-text" :size="16" /> CATATAN</div>
                            <p class="notes-text">{{ $r->catatan }}</p>
                        </div>
                    @endif
                </div>
            </details>
        @empty
            <div class="card-duo empty-card">
                <p>BELUM ADA RIDE. MULAI DARI HALAMAN MAP!</p>
                <a href="{{ route('map') }}" class="btn-duo btn-primary">BUKA MAP</a>
            </div>
        @endforelse
    </div>

    {{-- DAFTAR JALUR SEPEDA (CRUD + upload foto) --}}
    <div id="jalur" class="section-heading purple" style="margin-top:50px;">
        <h2>DAFTAR JALUR SEPEDA</h2>
        <a href="{{ route('jalur.create') }}" class="btn-duo btn-primary btn-sm"><x-icon name="plus" :size="16" /> TAMBAH JALUR</a>
    </div>

    <div class="activity-list">
        @forelse($jalur as $j)
            @php $lvl = strtolower($j->tingkat_kesulitan); @endphp
            <details class="card-duo activity-card" style="padding:0;">
                <summary class="activity-header">
                    <div class="activity-lead">
                        @if($j->foto)
                            <img class="activity-thumb" src="{{ asset('storage/'.$j->foto) }}" alt="{{ $j->nama }}">
                        @else
                            <div class="activity-icon-box"><x-icon name="map" :size="24" color="#fff" /></div>
                        @endif
                        <div style="min-width:0;">
                            <h3 class="activity-title">{{ $j->nama }}</h3>
                            <div class="activity-date-box">
                                <x-icon name="map-pin" :size="14" /> {{ $j->kota }}
                                <span class="lvl-badge {{ $lvl }}">{{ $j->tingkat_kesulitan }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="activity-main-stats">
                        <div class="mini-stat"><span class="val">{{ number_format($j->jarak_km, 1) }}</span><span class="unit">KM</span></div>
                        <span class="chev chev-closed"><x-icon name="chevron-down" :size="22" /></span>
                        <span class="chev chev-open"><x-icon name="chevron-up" :size="22" /></span>
                    </div>
                </summary>
                <div class="activity-detail-content">
                    @if($j->foto)
                        <img class="jalur-foto" src="{{ asset('storage/'.$j->foto) }}" alt="{{ $j->nama }}">
                    @endif
                    <div class="detail-grid">
                        <div class="detail-item"><div class="d-icon"><x-icon name="play" :size="20" color="#00a8e8" /></div>
                            <div><p class="d-label">TITIK AWAL</p><p class="d-value">{{ $j->titik_awal }}</p></div></div>
                        <div class="detail-item"><div class="d-icon"><x-icon name="flag" :size="20" color="#8e2de2" /></div>
                            <div><p class="d-label">TITIK AKHIR</p><p class="d-value">{{ $j->titik_akhir }}</p></div></div>
                        <div class="detail-item"><div class="d-icon"><x-icon name="bike" :size="20" color="#fc6719" /></div>
                            <div><p class="d-label">DIPAKAI RIDE</p><p class="d-value">{{ $j->aktivitas_count }}x</p></div></div>
                    </div>
                    @if($j->deskripsi)
                        <div class="activity-notes">
                            <div class="notes-label"><x-icon name="file-text" :size="16" /> DESKRIPSI</div>
                            <p class="notes-text">{{ $j->deskripsi }}</p>
                        </div>
                    @endif
                    <div class="jalur-actions">
                        <a href="{{ route('jalur.show', $j) }}" class="btn-duo btn-secondary btn-sm"><x-icon name="eye" :size="16" /> LIHAT</a>
                        <a href="{{ route('jalur.edit', $j) }}" class="btn-duo btn-outline btn-sm"><x-icon name="pencil" :size="16" /> EDIT</a>
                        <form action="{{ route('jalur.destroy', $j) }}" method="POST" onsubmit="return confirm('Hapus jalur {{ e($j->nama) }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-duo btn-danger btn-sm"><x-icon name="trash-2" :size="16" /> HAPUS</button>
                        </form>
                    </div>
                </div>
            </details>
        @empty
            <div class="card-duo empty-card">
                <p>BELUM ADA JALUR SEPEDA.</p>
                <a href="{{ route('jalur.create') }}" class="btn-duo btn-primary">TAMBAH JALUR</a>
            </div>
        @endforelse
    </div>

    @if($jalur->hasPages())
        {{ $jalur->links('pagination::bootstrap-4') }}
    @endif
</div>
@endsection
