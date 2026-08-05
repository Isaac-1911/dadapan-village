@extends('layouts.admin')

@section('page-title', 'Tambah Pengguna')

@section('content')
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Tambah Pengguna</h1>
            <p class="admin-page-subtitle">Buat akun admin baru untuk membantu mengelola portal desa</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="admin-btn admin-btn--ghost">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="admin-alert admin-alert--danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="admin-card" style="max-width: 560px;">
            <div class="admin-form-group">
                <label>Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" class="admin-input" required>
            </div>

            <div class="admin-form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="admin-input" required>
            </div>

            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="admin-input" required minlength="8">
                </div>
                <div class="admin-form-group">
                    <label>Telepon (opsional)</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="admin-input">
                </div>
            </div>

            <button type="submit" class="admin-btn admin-btn--primary">Buat Akun Admin</button>
        </div>
    </form>
@endsection
