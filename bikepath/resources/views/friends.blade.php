@extends('layouts.app')
@section('title', 'Friends - BikePath')


@section('content')
<div class="friends-page-wrapper animate-slide-in">
    <div class="page-title"><x-icon name="users" :size="40" color="#00a8e8" /><h1>FRIENDS</h1></div>

    {{-- SEARCH --}}
    <div class="section-container">
        <form method="GET" action="{{ route('friends') }}" class="search-box-glass">
            <span class="search-icon"><x-icon name="search" :size="20" color="#00a8e8" /></span>
            <input type="text" name="q" value="{{ $q }}" class="input-duo search-input-rider" placeholder="CARI RIDER...">
            @if($q !== '')
                <a href="{{ route('friends') }}" class="clear-btn"><x-icon name="x" :size="20" /></a>
            @endif
        </form>
    </div>

    @if($q !== '')
        <div class="section-container">
            <div class="section-title-row purple"><h2>HASIL PENCARIAN</h2></div>
            <div class="rider-grid">
                @forelse($results as $u)
                    @include('partials.rider', ['u' => $u, 'followed' => in_array($u->id, $followingIds)])
                @empty
                    <div class="card-duo empty-box-rider"><p class="empty-state-text">RIDER TIDAK DITEMUKAN.</p></div>
                @endforelse
            </div>
        </div>
    @endif

    {{-- FEATURED --}}
    @if($recommendations->count())
        <div class="section-container">
            <div class="section-title-row orange"><x-icon name="flame" :size="22" color="#fc6719" /><h2>FEATURED RIDERS</h2></div>
            <div class="rider-scroll-row">
                @foreach($recommendations as $u)
                    <div class="card-duo featured-card glass">
                        <div class="featured-badge"><x-icon name="star" :size="10" fill="#fc6719" /> FEATURED</div>
                        <div class="featured-avatar"><div class="avatar-ring">
                            @if($u->avatar_url)<img src="{{ $u->avatar_url }}" alt="">@else<div class="icon-placeholder-ring"><x-icon name="user" :size="32" color="#00a8e8" /></div>@endif
                        </div></div>
                        <span class="featured-name">{{ $u->name }}</span>
                        <span class="featured-level">{{ $u->cycling_level ?? 'beginner' }}</span>
                        <form method="POST" action="{{ route('friends.follow', $u) }}">
                            @csrf
                            <button type="submit" class="btn-duo btn-primary">FOLLOW</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- JARINGAN SAYA --}}
    <div class="section-container">
        <div class="section-title-row"><h2>JARINGAN SAYA</h2><h3>({{ $following->count() }})</h3></div>
        <div class="rider-grid">
            @forelse($following as $u)
                @include('partials.rider', ['u' => $u, 'followed' => true])
            @empty
                <div class="card-duo empty-box-rider"><p class="empty-state-text">KAMU BELUM MENGIKUTI SIAPAPUN.</p></div>
            @endforelse
        </div>
    </div>
</div>
@endsection
