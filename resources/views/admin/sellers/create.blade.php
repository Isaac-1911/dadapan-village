@extends('layouts.admin')

@section('page-title', 'Tambah Seller')

@section('content')
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Tambah Seller</h1>
            <p class="admin-page-subtitle">Buat akun login sekaligus profil UMKM untuk seller baru</p>
        </div>
        <a href="{{ route('admin.sellers.index') }}" class="admin-btn admin-btn--ghost">
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

    <form method="POST" action="{{ route('admin.sellers.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="admin-form-grid">
            <div class="admin-card">
                <h3 class="admin-card__title">Akun Login</h3>

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label>Nama</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="admin-input" required>
                    </div>
                    <div class="admin-form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="admin-input" required>
                    </div>
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

                <h3 class="admin-card__title" style="margin-top: 1.5rem;">Profil UMKM</h3>

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label>Nama Usaha</label>
                        <input type="text" name="business_name" value="{{ old('business_name') }}" class="admin-input" required>
                    </div>
                    <div class="admin-form-group">
                        <label>Nama Pemilik</label>
                        <input type="text" name="owner_name" value="{{ old('owner_name') }}" class="admin-input" required>
                    </div>
                </div>

                <div class="admin-form-group">
                    <label>Nomor WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" class="admin-input" placeholder="628123456789" required>
                </div>

                <div class="admin-form-group">
                    <label>Alamat</label>
                    <textarea name="address" rows="2" class="admin-input" required>{{ old('address') }}</textarea>
                </div>

                <div class="admin-form-group">
                    <label>Deskripsi Usaha (opsional)</label>
                    <textarea name="description" rows="3" class="admin-input">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="admin-form-sidebar">
                <div class="admin-card">
                    <h3 class="admin-card__title">Logo UMKM</h3>
                    <div class="admin-form-group">
                        <div class="admin-upload">
                            <img id="preview-create-seller" class="admin-upload__preview" style="display:none;">
                            <div id="preview-create-seller-placeholder" class="admin-upload__placeholder">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3 3.75h18v16.5H3V3.75Z" /></svg>
                                <span>Klik untuk upload logo</span>
                            </div>
                        </div>
                        <input type="file" name="logo" accept="image/*" class="admin-input" data-image-preview="preview-create-seller">
                        <p class="admin-form-hint">Opsional. Maks 2MB.</p>
                    </div>

                    <button type="submit" class="admin-btn admin-btn--primary admin-btn--block">Buat Akun Seller</button>
                </div>
            </div>
        </div>
    </form>
@endsection
