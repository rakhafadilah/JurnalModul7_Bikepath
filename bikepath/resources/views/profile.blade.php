@extends('layouts.app')
@section('title', 'Profile - BikePath')
@section('inline_errors', '1')

@section('content')
@php
    $levelLabel = ['beginner' => 'BEGINNER RIDER', 'intermediate' => 'INTERMEDIATE RIDER', 'pro' => 'PRO RIDER'][$user->cycling_level ?? 'beginner'] ?? 'RIDER';
@endphp
<div class="profile-container animate-slide-in">
    <div class="page-title"><h1 class="profile-title"><x-icon name="user" :size="40" color="#00a8e8" /> PROFILE</h1></div>

    @if($errors->any())
        <div class="flash err"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif

    <div class="profile-grid">
        <div class="profile-left">
            <div class="card-duo profile-card">
                <div class="profile-glow"></div>
                <div class="avatar-wrap">
                    <div class="avatar-ring-lg"><div class="avatar-inner">
                        @if($user->avatar_url)<img src="{{ $user->avatar_url }}" alt="avatar">@else<x-icon name="user" :size="80" color="#94a3b8" />@endif
                    </div></div>
                    <form class="camera-form" method="POST" action="{{ route('profile.avatar') }}" enctype="multipart/form-data" id="avatarForm">
                        @csrf
                        <input type="file" name="avatar" id="avatarInput" accept=".jpg,.jpeg,.png" hidden onchange="document.getElementById('avatarForm').submit()">
                        <button type="button" class="btn-duo btn-primary camera-btn" onclick="document.getElementById('avatarInput').click()"><x-icon name="camera" :size="20" /></button>
                    </form>
                </div>
                <h2 class="profile-name">{{ $user->name }}</h2>
                <div class="elite-badge"><x-icon name="award" :size="16" /> {{ $levelLabel }}</div>
            </div>
            <div class="card-duo rank-card">
                <div class="rank-row">
                    <div class="rank-icon"><x-icon name="trophy" :size="24" color="#fff" /></div>
                    <div><h4>RIDER RANK</h4><p>{{ ucfirst($user->cycling_level ?? 'beginner') }}</p></div>
                </div>
            </div>
        </div>

        <div class="card-duo data-card">
            <div class="data-head">
                <h3>DATA RIDER</h3>
                @if($editing)
                    <a href="{{ route('profile') }}" class="btn-duo btn-edit">BATAL</a>
                @else
                    <a href="{{ route('profile', ['edit' => 1]) }}" class="btn-duo btn-edit"><x-icon name="pencil" :size="16" /> EDIT</a>
                @endif
            </div>
            <div class="data-body">
                @if($editing)
                    <form method="POST" action="{{ route('profile.update') }}" class="edit-form">
                        @csrf @method('PATCH')
                        <div class="form-row"><label>USERNAME</label><input type="text" name="name" class="input-duo" value="{{ old('name', $user->name) }}" required></div>
                        <div class="form-row"><label>NAMA LENGKAP</label><input type="text" name="full_name" class="input-duo" value="{{ old('full_name', $user->full_name) }}"></div>
                        <div class="info-two">
                            <div class="form-row"><label>JENIS SEPEDA</label><input type="text" name="bike_type" class="input-duo" value="{{ old('bike_type', $user->bike_type) }}"></div>
                            <div class="form-row"><label>LEVEL</label>
                                <select name="cycling_level" class="input-duo">
                                    @foreach(['beginner' => 'Beginner', 'intermediate' => 'Intermediate', 'pro' => 'Pro'] as $v => $l)
                                        <option value="{{ $v }}" @selected(old('cycling_level', $user->cycling_level ?? 'beginner') === $v)>{{ $l }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row"><label>ALAMAT</label><textarea name="address" class="input-duo">{{ old('address', $user->address) }}</textarea></div>
                        <button type="submit" class="btn-duo btn-primary full-width">SIMPAN PERUBAHAN</button>
                    </form>
                @else
                    <div class="info-list">
                        <div class="info-block"><label>NAMA LENGKAP</label>
                            <div class="info-line"><x-icon name="user" :size="24" color="#00a8e8" /><span class="val-text">{{ $user->full_name ?: $user->name }}</span></div></div>
                        <div class="divider"></div>
                        <div class="info-two">
                            <div class="info-block"><label>JENIS SEPEDA</label>
                                <div class="info-line"><x-icon name="bike" :size="22" color="#8e2de2" /><span class="val-text-small">{{ $user->bike_type ?: '-' }}</span></div></div>
                            <div class="info-block"><label>EMAIL</label>
                                <div class="info-line"><x-icon name="mail" :size="22" color="#fc6719" /><span class="val-text-small">{{ $user->email }}</span></div></div>
                        </div>
                        <div class="divider"></div>
                        <div class="info-block"><label>ALAMAT</label>
                            <div class="info-line top"><x-icon name="map-pin" :size="22" color="#00a8e8" /><span class="val-text-small">{{ $user->address ?: '-' }}</span></div></div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
