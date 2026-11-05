<div class="rider-card glass">
    <div class="rider-info-main">
        <div class="rider-avatar-box {{ $followed ? 'active' : '' }}">
            @if($u->avatar_url)<img src="{{ $u->avatar_url }}" alt="">@else<x-icon name="user" :size="22" color="{{ $followed ? '#fff' : '#94a3b8' }}" />@endif
        </div>
        <div class="rider-names">
            <span class="rider-username">{{ $u->name }}</span>
            <span class="rider-rank">{{ $u->cycling_level ?? 'beginner' }}</span>
        </div>
    </div>
    @if($followed)
        <div style="display:flex;align-items:center;gap:10px;">
            <span class="btn-status"><x-icon name="check" :size="12" /> FOLLOWING</span>
            <form method="POST" action="{{ route('friends.unfollow', $u) }}">
                @csrf @method('DELETE')
                <button type="submit" class="unfollow-btn" title="Unfollow"><x-icon name="user-minus" :size="20" /></button>
            </form>
        </div>
    @else
        <form method="POST" action="{{ route('friends.follow', $u) }}">
            @csrf
            <button type="submit" class="btn-duo btn-primary btn-mini">FOLLOW</button>
        </form>
    @endif
</div>
