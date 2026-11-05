@extends('layouts.app')
@section('title', 'Map - BikePath')

@push('head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
@endpush

@section('content')
<div class="map-page-wrapper glass">
    <div class="map-area">
        <div id="map"></div>

        {{-- Route planner --}}
        <div class="route-planner-overlay glass-luminous" id="planner" style="display:none;">
            <div class="planner-header">
                <h3>RUTE SAYA</h3>
                <button type="button" class="close-planner" id="closePlanner"><x-icon name="x" :size="20" /></button>
            </div>
            <div class="input-group-float">
                <label><x-icon name="map-pin" :size="12" /> TITIK AWAL</label>
                <input type="text" class="input-duo-mini luminous" id="routeStart" placeholder="Lokasi saat ini">
            </div>
            <div class="input-group-float">
                <label><x-icon name="flag" :size="12" /> TUJUAN</label>
                <input type="text" class="input-duo-mini luminous" id="routeEnd" placeholder="Mau gowes ke mana?">
            </div>
            <button type="button" class="btn-duo btn-primary full-width btn-sm" id="btnRoute">CARI RUTE</button>
        </div>

        {{-- Tracking controls --}}
        <div class="tracking-controls">
            <div class="in-ride-tools-floating" id="rideTools" style="display:none;">
                <button type="button" class="tool-btn-float sos" data-poi="sos" title="SOS"><x-icon name="siren" :size="22" /></button>
                <button type="button" class="tool-btn-float rest" data-poi="rest" title="Rest area"><x-icon name="coffee" :size="22" /></button>
                <button type="button" class="tool-btn-float toilet" data-poi="toilet" title="Toilet"><x-icon name="droplets" :size="22" /></button>
            </div>
            <div class="stats-bubble-modern" id="statsBubble" style="display:none;">
                <span class="km-val" id="kmVal">0.00</span><span class="km-unit">KM</span>
            </div>
            <button type="button" class="btn-track secondary" id="btnPlanner" title="Rute"><x-icon name="route" :size="26" /></button>
            <button type="button" class="btn-track start" id="btnTrack"><x-icon name="play" :size="30" fill="#fff" /></button>
        </div>

        {{-- Save ride modal --}}
        <div class="save-ride-overlay" id="saveOverlay" style="display:none;">
            <div class="card-duo save-ride-card animate-slide-in">
                <div class="save-header">
                    <div class="zap-icon"><x-icon name="zap" :size="22" color="#fff" /></div>
                    <h2 class="save-title">SIMPAN RIDE</h2>
                </div>
                <div class="form-row">
                    <label>JUDUL</label>
                    <input type="text" id="rideTitle" class="input-duo" placeholder="Morning Ride" maxlength="255">
                </div>
                <div class="form-row">
                    <label>JALUR SEPEDA</label>
                    <select id="rideJalur" class="input-duo">
                        @foreach($jalur as $j)
                            <option value="{{ $j->id }}">{{ $j->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-row">
                    <label>CATATAN</label>
                    <textarea id="rideNotes" class="input-duo" rows="3" placeholder="Bagaimana ride kamu?"></textarea>
                </div>
                <p class="muted-text" id="rideSummary"></p>
                <div class="save-error" id="saveError"></div>
                <div class="save-actions">
                    <button type="button" class="btn-duo btn-outline" id="btnDiscard">BUANG</button>
                    <button type="button" class="btn-duo btn-primary" id="btnSave">SIMPAN</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
(function () {
    const START = [-6.2, 106.816666];
    const map = L.map('map', { zoomControl: false }).setView(START, 14);
    L.control.zoom({ position: 'topright' }).addTo(map);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
    setTimeout(() => map.invalidateSize(), 200);

    const userIcon = L.divIcon({
        className: 'custom-logo-marker',
        html: '<div style="width:22px;height:22px;border-radius:50%;background:#00a8e8;border:4px solid #fff;box-shadow:0 0 15px #00a8e8"></div>',
        iconSize: [22, 22], iconAnchor: [11, 11]
    });
    const userMarker = L.marker(START, { icon: userIcon }).addTo(map);

    // Fasilitas (sama seperti desain asli: SOS, rest area, toilet)
    const POIS = {
        sos:    { color: '#ff0000', title: 'SOS - RUMAH SAKIT', phone: '119', items: [[-6.195, 106.822, 'RS Cikini'], [-6.208, 106.810, 'RS Pusat Pertamina']] },
        rest:   { color: '#fc6719', title: 'REST AREA',         phone: null, items: [[-6.202, 106.819, 'Warung Gowes'], [-6.198, 106.812, 'Taman Menteng']] },
        toilet: { color: '#00a8e8', title: 'TOILET UMUM',       phone: null, items: [[-6.204, 106.814, 'Toilet Sarinah'], [-6.199, 106.820, 'Toilet Halte']] }
    };
    const poiLayers = {};
    Object.keys(POIS).forEach(k => poiLayers[k] = L.layerGroup());

    Object.entries(POIS).forEach(([k, p]) => {
        p.items.forEach(([lat, lng, name]) => {
            const icon = L.divIcon({
                className: 'custom-logo-marker',
                html: '<div style="width:18px;height:18px;border-radius:50%;background:' + p.color + ';border:3px solid #fff"></div>',
                iconSize: [18, 18], iconAnchor: [9, 9]
            });
            const phone = p.phone ? '<div class="phone-row">&#9742; ' + p.phone + '</div>' : '';
            const html = '<div class="sos-popup"><div class="popup-sos-header" style="background:' + p.color + '">' + p.title + '</div>' +
                '<div class="popup-body"><strong>' + name + '</strong>' + phone + '</div></div>';
            L.marker([lat, lng], { icon }).bindPopup(html).addTo(poiLayers[k]);
        });
    });

    document.querySelectorAll('[data-poi]').forEach(btn => {
        btn.addEventListener('click', () => {
            const k = btn.dataset.poi;
            const on = map.hasLayer(poiLayers[k]);
            on ? map.removeLayer(poiLayers[k]) : poiLayers[k].addTo(map);
            btn.classList.toggle('active', !on);
        });
    });

    // Tracking (simulasi tiap 3 detik, sama seperti desain asli)
    let tracking = false, timer = null, pos = START.slice(), distance = 0, startedAt = null;
    let line = L.polyline([START], { color: '#00a8e8', weight: 6 }).addTo(map);
    const $ = id => document.getElementById(id);

    function haversine(a, b) {
        const R = 6371, rad = x => x * Math.PI / 180;
        const dLat = rad(b[0] - a[0]), dLng = rad(b[1] - a[1]);
        const h = Math.sin(dLat / 2) ** 2 + Math.cos(rad(a[0])) * Math.cos(rad(b[0])) * Math.sin(dLng / 2) ** 2;
        return 2 * R * Math.asin(Math.sqrt(h));
    }

    function setBtn(running) {
        const b = $('btnTrack');
        b.className = 'btn-track ' + (running ? 'stop' : 'start');
        b.innerHTML = running ? '<i data-lucide="square" style="width:28px;height:28px;fill:#fff"></i>'
                              : '<i data-lucide="play" style="width:30px;height:30px;fill:#fff"></i>';
        lucide.createIcons();
    }

    function startTracking() {
        tracking = true; distance = 0; pos = START.slice(); startedAt = Date.now();
        line.setLatLngs([pos]);
        $('statsBubble').style.display = 'flex';
        $('rideTools').style.display = 'flex';
        $('kmVal').textContent = '0.00';
        setBtn(true);
        timer = setInterval(() => {
            const next = [pos[0] + (Math.random() * 0.0009 + 0.0003), pos[1] + (Math.random() * 0.0009 - 0.0002)];
            distance += haversine(pos, next);
            pos = next;
            line.addLatLng(pos);
            userMarker.setLatLng(pos);
            map.panTo(pos);
            $('kmVal').textContent = distance.toFixed(2);
        }, 3000);
    }

    function stopTracking() {
        tracking = false; clearInterval(timer);
        setBtn(false);
        $('rideTools').style.display = 'none';
        const minutes = Math.max(1, Math.round((Date.now() - startedAt) / 60000));
        const km = Math.max(0.01, distance);
        $('rideSummary').textContent = 'Jarak ' + km.toFixed(2) + ' km · Durasi ' + minutes + ' menit';
        $('saveOverlay').dataset.km = km.toFixed(2);
        $('saveOverlay').dataset.min = minutes;
        $('saveError').textContent = '';
        $('saveOverlay').style.display = 'flex';
    }

    $('btnTrack').addEventListener('click', () => tracking ? stopTracking() : startTracking());
    $('btnPlanner').addEventListener('click', () => { const p = $('planner'); p.style.display = p.style.display === 'none' ? 'block' : 'none'; });
    $('closePlanner').addEventListener('click', () => $('planner').style.display = 'none');
    $('btnRoute').addEventListener('click', () => {
        const end = $('routeEnd').value.trim();
        if (!end) return;
        const target = [START[0] + 0.01, START[1] + 0.012];
        L.polyline([START, target], { color: '#8e2de2', weight: 5, dashArray: '8 10' }).addTo(map);
        map.fitBounds([START, target], { padding: [60, 60] });
    });

    function closeSave() {
        $('saveOverlay').style.display = 'none';
        $('statsBubble').style.display = 'none';
        line.setLatLngs([START]); userMarker.setLatLng(START);
    }
    $('btnDiscard').addEventListener('click', closeSave);

    $('btnSave').addEventListener('click', async () => {
        const ov = $('saveOverlay');
        const sel = $('rideJalur');
        if (!sel.value) { $('saveError').textContent = 'Belum ada jalur sepeda. Tambahkan dulu di halaman Activity.'; return; }
        $('btnSave').disabled = true;
        try {
            const res = await fetch(@json(route('aktivitas.store')), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json', 'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: JSON.stringify({
                    judul: $('rideTitle').value || 'Morning Ride',
                    jalur_sepeda_id: sel.value,
                    durasi_menit: parseInt(ov.dataset.min, 10),
                    jarak_km: parseFloat(ov.dataset.km),
                    catatan: $('rideNotes').value
                })
            });
            const data = await res.json();
            if (res.ok && data.status) { window.location.href = @json(route('activity')); }
            else { $('saveError').textContent = data.message || Object.values(data.errors || {}).flat().join(' ') || 'Gagal menyimpan.'; }
        } catch (e) { $('saveError').textContent = 'Gagal menyimpan ride.'; }
        $('btnSave').disabled = false;
    });
})();
</script>
@endpush
