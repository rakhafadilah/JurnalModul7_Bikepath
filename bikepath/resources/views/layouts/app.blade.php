<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BikePath')</title>
    <link rel="stylesheet" href="{{ asset('css/bikepath.css') }}">
    @stack('head')
</head>
<body>
@auth
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('map') }}" class="nav-logo">
                <x-icon name="bike" :size="30" color="#00a8e8" /> BIKE<span>PATH</span>
            </a>
            <button type="button" class="menu-icon" id="menuToggle" aria-label="Menu"><x-icon name="menu" :size="28" /></button>
            <ul class="nav-menu" id="navMenu">
                <li><a href="{{ route('map') }}" class="nav-links {{ request()->routeIs('map') ? 'active' : '' }}">Map</a></li>
                <li><a href="{{ route('activity') }}" class="nav-links {{ request()->routeIs('activity', 'jalur.*') ? 'active' : '' }}">Activity</a></li>
                <li><a href="{{ route('community') }}" class="nav-links {{ request()->routeIs('community*') ? 'active' : '' }}">Community</a></li>
                <li><a href="{{ route('friends') }}" class="nav-links {{ request()->routeIs('friends*') ? 'active' : '' }}">Friends</a></li>
                <li>
                    <a href="{{ route('profile') }}" class="nav-links profile-trigger" title="Profile">
                        <div class="profile-avatar">
                            @if(auth()->user()->avatar_url)
                                <img src="{{ auth()->user()->avatar_url }}" alt="avatar">
                            @else
                                <x-icon name="user" :size="20" />
                            @endif
                        </div>
                    </a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-links" style="background:none;border:none;cursor:pointer;" title="Logout"><x-icon name="log-out" :size="18" /></button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
@endauth

<div class="main-content">
    @if(session('success'))
        <div class="flash ok">{{ session('success') }}</div>
    @endif
    @if($errors->any() && ! View::hasSection('inline_errors'))
        <div class="flash err"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif

    @yield('content')
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    document.getElementById('menuToggle')?.addEventListener('click', function () {
        document.getElementById('navMenu').classList.toggle('active');
    });
</script>
@stack('scripts')
<script>lucide.createIcons();</script>
</body>
</html>
