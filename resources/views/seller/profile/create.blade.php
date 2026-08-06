@extends('layouts.seller')

@section('page-title', 'Lengkapi Profil UMKM')

@section('content')
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Lengkapi Profil UMKM</h1>
            <p class="admin-page-subtitle">Isi informasi usaha Anda sebelum mulai menambahkan produk</p>
        </div>
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

    <form method="POST" action="{{ route('seller.profile.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="admin-form-grid">
            <div class="admin-card">
                <h3 class="admin-card__title">Informasi Usaha</h3>

                <div class="admin-form-group">
                    <label>Nama Usaha</label>
                    <input type="text" name="business_name" value="{{ old('business_name') }}" class="admin-input" required autofocus>
                </div>

                <div class="admin-form-group">
                    <label>Nama Pemilik</label>
                    <input type="text" name="owner_name" value="{{ old('owner_name') }}" class="admin-input" required>
                </div>

                <div class="admin-form-group">
                    <label>Deskripsi Usaha</label>
                    <textarea name="description" rows="5" class="admin-input" placeholder="Ceritakan tentang usaha Anda...">{{ old('description') }}</textarea>
                </div>

                <div class="admin-form-group">
                    <label>Alamat</label>
                    <textarea name="address" rows="2" class="admin-input" required>{{ old('address') }}</textarea>
                </div>

                <div class="admin-form-group">
                    <label>Nomor WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" class="admin-input" placeholder="628123456789" required>
                    <p class="admin-form-hint">Format: 62xxxxxxxxxx — dipakai pembeli buat menghubungi Anda lewat katalog produk.</p>
                </div>
            </div>

            <div class="admin-form-sidebar">
                <div class="admin-card">
                    <h3 class="admin-card__title">Logo UMKM</h3>

                    <div class="admin-form-group">
                        <div class="admin-upload">
                            <img id="preview-create-seller-logo" class="admin-upload__preview" style="display:none;">
                            <div id="preview-create-seller-logo-placeholder" class="admin-upload__placeholder">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3 3.75h18v16.5H3V3.75Z" /></svg>
                                <span>Klik untuk upload logo</span>
                            </div>
                        </div>
                        <input type="file" name="logo" accept="image/*" class="admin-input" data-image-preview="preview-create-seller-logo">
                        <p class="admin-form-hint">Opsional. Maks 2MB.</p>
                    </div>
                </div>

                <button type="submit" class="admin-btn admin-btn--primary admin-btn--block">Simpan & Lanjutkan</button>
            </div>
        </div>
    </form>
@endsection
