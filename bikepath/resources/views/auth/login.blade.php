@extends('layouts.app')
@section('title', 'Login - BikePath')
@section('inline_errors', '1')
@section('content')
<div class="auth-wrapper animate-slide-in">
    <div class="card-duo auth-card">
        <div class="auth-logo">
            <div class="auth-logo-icon"><x-icon name="bike" :size="36" color="#fff" /></div>
            <h1>BIKE<span>PATH</span></h1>
        </div>
        <p class="auth-tagline">LOGIN UNTUK MULAI BERSEPEDA</p>

        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf
            <div class="input-with-icon">
                <span class="field-icon"><x-icon name="mail" :size="20" color="#00a8e8" /></span>
                <input type="email" name="email" class="input-duo" placeholder="Email" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="input-with-icon">
                <span class="field-icon"><x-icon name="lock" :size="20" color="#00a8e8" /></span>
                <input type="password" name="password" class="input-duo" placeholder="Password" required>
            </div>
            <label class="remember"><input type="checkbox" name="remember" value="1"> INGAT SAYA</label>
            <button type="submit" class="btn-duo btn-primary full-width">LOGIN <x-icon name="log-in" :size="20" /></button>
        </form>

        @if($errors->any())
            <div class="auth-error"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif

        <div class="auth-switch">
            <p>BELUM PUNYA AKUN?</p>
            <a href="{{ route('register') }}" class="btn-duo btn-secondary full-width">DAFTAR SEKARANG</a>
        </div>
    </div>
</div>
@endsection
