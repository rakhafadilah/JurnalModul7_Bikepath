@extends('layouts.app')
@section('title', 'Community - BikePath')

@section('content')
<div class="card-duo community-container glass animate-slide-in">
    <div class="sidebar">
        <div class="sidebar-head"><h2>KOMUNITAS</h2></div>
        <div class="group-list">
            @foreach($groups as $g)
                @php $joined = in_array($g->id, $memberIds); @endphp
                <div class="group-item {{ $active && $active->id === $g->id ? 'active' : '' }}">
                    <a class="group-link" href="{{ route('community', ['g' => $g->id]) }}">
                        <span class="group-name">{{ $g->nama }}</span>
                        <span class="group-count">{{ $g->kota }} · {{ $g->jumlah_anggota }} anggota</span>
                    </a>
                    <form method="POST" action="{{ route($joined ? 'community.leave' : 'community.join', $g) }}">
                        @csrf
                        <button type="submit" class="btn-join-mini {{ $joined ? 'joined' : '' }}">{{ $joined ? 'JOINED' : 'JOIN' }}</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

    @if($active)
        @php $isMember = in_array($active->id, $memberIds); @endphp
        <div class="main-panel">
            <div class="panel-header">
                <div>
                    <h3>{{ $active->nama }}</h3>
                    <p>{{ $active->kota }} · {{ $active->jumlah_anggota }} anggota</p>
                </div>
                <div class="tab-btns">
                    <a class="tab-btn {{ $tab === 'chat' ? 'active' : '' }}" href="{{ route('community', ['g' => $active->id, 'tab' => 'chat']) }}"><x-icon name="message-circle" :size="22" /></a>
                    <a class="tab-btn {{ $tab === 'members' ? 'active' : '' }}" href="{{ route('community', ['g' => $active->id, 'tab' => 'members']) }}"><x-icon name="users" :size="22" /></a>
                </div>
            </div>
            <div class="panel-content">
                @if($tab === 'chat')
                    <div class="chat-wrap">
                        <div class="message-list" id="messageList">
                            @forelse($messages as $m)
                                <div class="message-bubble">
                                    <div class="message-meta">
                                        <span class="message-user">{{ $m->user->name ?? 'Rider' }}</span>
                                        <span class="message-time">{{ $m->created_at->format('H:i') }}</span>
                                    </div>
                                    <div class="message-text glass"><p>{{ $m->pesan }}</p></div>
                                </div>
                            @empty
                                <div class="chat-empty"><x-icon name="message-circle" :size="40" /><p>BELUM ADA PESAN. MULAI OBROLAN!</p></div>
                            @endforelse
                        </div>
                        @if($isMember)
                            <form class="chat-input" method="POST" action="{{ route('community.send', $active) }}">
                                @csrf
                                <input type="text" name="pesan" class="input-duo" placeholder="Tulis pesan..." maxlength="1000" required autocomplete="off">
                                <button type="submit" class="btn-duo btn-primary chat-send"><x-icon name="send" :size="20" /></button>
                            </form>
                        @else
                            <div class="chat-join-note"><p>JOIN KOMUNITAS INI UNTUK IKUT BERDISKUSI</p></div>
                        @endif
                    </div>
                @else
                    <div class="members-grid">
                        @forelse($members as $u)
                            <div class="member-card glass">
                                <div class="member-avatar"><div>
                                    @if($u->avatar_url)<img src="{{ $u->avatar_url }}" alt="">@else<x-icon name="user" :size="22" />@endif
                                </div></div>
                                <div class="member-info">
                                    <span class="member-name">{{ $u->name }}</span>
                                    <span class="member-level">{{ $u->cycling_level ?? 'beginner' }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state-text">Belum ada anggota.</div>
                        @endforelse
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="main-panel panel-empty">
            <div class="panel-empty-icon"><x-icon name="users" :size="48" /></div>
            <p>PILIH KOMUNITAS UNTUK MULAI</p>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    const ml = document.getElementById('messageList');
    if (ml) ml.scrollTop = ml.scrollHeight;
</script>
@endpush
