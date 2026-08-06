@extends('layouts.seller')

@section('page-title', 'Profil UMKM')

@section('content')
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Profil UMKM</h1>
            <p class="admin-page-subtitle">Kelola informasi usaha Anda yang tampil di katalog publik</p>
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

    <form method="POST" action="{{ route('seller.profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="admin-form-grid">
            <div class="admin-card">
                <h3 class="admin-card__title">Informasi Usaha</h3>

                <div class="admin-form-group">
                    <label>Nama Usaha</label>
                    <input type="text" name="business_name" value="{{ old('business_name', $sellerProfile->business_name) }}" class="admin-input" required>
                </div>

                <div class="admin-form-group">
                    <label>Nama Pemilik</label>
                    <input type="text" name="owner_name" value="{{ old('owner_name', $sellerProfile->owner_name) }}" class="admin-input" required>
                </div>

                <div class="admin-form-group">
                    <label>Deskripsi Usaha</label>
                    <textarea name="description" rows="5" class="admin-input" placeholder="Ceritakan tentang usaha Anda, produk unggulan, dan sejarah singkatnya...">{{ old('description', $sellerProfile->description) }}</textarea>
                </div>

                <div class="admin-form-group">
                    <label>Alamat</label>
                    <textarea name="address" rows="2" class="admin-input" required>{{ old('address', $sellerProfile->address) }}</textarea>
                </div>

                <div class="admin-form-group">
                    <label>Nomor WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $sellerProfile->whatsapp) }}" class="admin-input" placeholder="628123456789" required>
                    <p class="admin-form-hint">Format: 62xxxxxxxxxx — nomor ini yang dipakai pembeli buat menghubungi Anda lewat katalog produk.</p>
                </div>
            </div>

            <div class="admin-form-sidebar">
                <div class="admin-card">
                    <h3 class="admin-card__title">Logo UMKM</h3>

                    <div class="admin-form-group">
                        <div class="admin-upload">
                            <img id="preview-edit-seller-logo"
                                 class="admin-upload__preview"
                                 src="{{ $sellerProfile->logo ? asset('storage/' . $sellerProfile->logo) : '' }}"
                                 style="{{ $sellerProfile->logo ? 'display:block;' : 'display:none;' }}">
                            <div id="preview-edit-seller-logo-placeholder"
                                 class="admin-upload__placeholder"
                                 style="{{ $sellerProfile->logo ? 'display:none;' : 'display:flex;' }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3 3.75h18v16.5H3V3.75Z" /></svg>
                                <span>Klik untuk upload logo</span>
                            </div>
                        </div>
                        <input type="file" name="logo" accept="image/*" class="admin-input" data-image-preview="preview-edit-seller-logo">
                        <p class="admin-form-hint">Kosongkan jika tidak ingin mengganti logo. Maks 2MB.</p>
                    </div>
                </div>

                <div class="admin-card">
                    <h3 class="admin-card__title">Akun Login</h3>
                    <div class="admin-form-group">
                        <label>Email</label>
                        <input type="text" value="{{ auth()->user()->email }}" class="admin-input" disabled>
                        <p class="admin-form-hint">Hubungi admin kalau ingin mengganti email atau password.</p>
                    </div>
                </div>

                <button type="submit" class="admin-btn admin-btn--primary admin-btn--block">Simpan Perubahan</button>
            </div>
        </div>
    </form>
@endsection
