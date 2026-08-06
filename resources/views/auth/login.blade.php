@extends('layouts.auth')

@section('page-title', 'Masuk')

@section('content')
    <h1 class="admin-auth-title">Masuk ke Portal</h1>
    <p class="admin-auth-subtitle">Silakan masuk menggunakan akun yang terdaftar</p>

    @if (session('status'))
        <div class="admin-alert admin-alert--success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="admin-form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="admin-input" required autofocus autocomplete="username">
            @error('email')
                <p class="admin-form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="admin-form-group">
            <label>Password</label>
            <input type="password" name="password" class="admin-input" required autocomplete="current-password">
            @error('password')
                <p class="admin-form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="admin-auth-row">
            <label class="admin-checkbox">
                <input type="checkbox" name="remember">
                <span>Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="admin-auth-link">Lupa password?</a>
            @endif
        </div>

        <button type="submit" class="admin-btn admin-btn--primary admin-btn--block">Masuk</button>
    </form>
@endsection
