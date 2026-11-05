@extends('layouts.app')
@section('title', 'Register - BikePath')
@section('inline_errors', '1')
@section('content')
<div class="auth-wrapper animate-slide-in">
    <div class="card-duo auth-card purple">
        <div class="auth-logo">
            <div class="auth-logo-icon"><x-icon name="bike" :size="36" color="#fff" /></div>
            <h1>BIKE<span>PATH</span></h1>
        </div>
        <p class="auth-tagline">BUAT AKUN & GABUNG KOMUNITAS</p>

        <form method="POST" action="{{ route('register') }}" class="auth-form">
            @csrf
            <div class="input-with-icon">
                <span class="field-icon"><x-icon name="user" :size="20" color="#8e2de2" /></span>
                <input type="text" name="name" class="input-duo" placeholder="Username" value="{{ old('name') }}" required autofocus>
            </div>
            <div class="input-with-icon">
                <span class="field-icon"><x-icon name="mail" :size="20" color="#8e2de2" /></span>
                <input type="email" name="email" class="input-duo" placeholder="Email" value="{{ old('email') }}" required>
            </div>
            <div class="input-with-icon">
                <span class="field-icon"><x-icon name="lock" :size="20" color="#8e2de2" /></span>
                <input type="password" name="password" class="input-duo" placeholder="Password" required>
            </div>
            <div class="input-with-icon">
                <span class="field-icon"><x-icon name="lock" :size="20" color="#8e2de2" /></span>
                <input type="password" name="password_confirmation" class="input-duo" placeholder="Konfirmasi Password" required>
            </div>
            <button type="submit" class="btn-duo btn-primary full-width">DAFTAR <x-icon name="user-plus" :size="20" /></button>
        </form>

        @if($errors->any())
            <div class="auth-error"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif

        <div class="auth-switch">
            <p>SUDAH PUNYA AKUN?</p>
            <a href="{{ route('login') }}" class="btn-duo btn-secondary full-width">LOGIN</a>
        </div>
    </div>
</div>
@endsection
