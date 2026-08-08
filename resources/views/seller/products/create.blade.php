@extends('layouts.seller')

@section('page-title', 'Tambah Produk')

@section('content')
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Tambah Produk</h1>
            <p class="admin-page-subtitle">Tambahkan produk baru ke katalog UMKM Anda</p>
        </div>
        <a href="{{ route('seller.products.index') }}" class="admin-btn admin-btn--ghost">
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

    <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="admin-form-grid">
            <div class="admin-card">
                <div class="admin-form-group">
                    <label>Nama Produk</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="admin-input" placeholder="Contoh: Tas Anyaman Bambu Motif Kotak" required>
                </div>

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label>Harga (Rp)</label>
                        <input type="number" name="price" value="{{ old('price') }}" class="admin-input" min="0" required>
                    </div>
                    <div class="admin-form-group">
                        <label>Stok</label>
                        <input type="number" name="stock" value="{{ old('stock') }}" class="admin-input" min="0" required>
                    </div>
                </div>

                <div class="admin-form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" rows="8" class="admin-input" placeholder="Jelaskan bahan, ukuran, keunggulan produk..." required>{{ old('description') }}</textarea>
                </div>

                <div class="admin-form-group">
                    <label>Gambar Tambahan (opsional, bisa pilih beberapa sekaligus)</label>
                    <input type="file" name="images[]" accept="image/*" class="admin-input" multiple>
                </div>
            </div>

            <div class="admin-form-sidebar">
                <div class="admin-card">
                    <h3 class="admin-card__title">Publikasi</h3>

                    <div class="admin-form-group">
                        <label>Status</label>
                        <select name="status" class="admin-input">
                            <option value="1" @selected(old('status', '1') === '1')>Aktif</option>
                            <option value="0" @selected(old('status') === '0')>Nonaktif</option>
                        </select>
                    </div>

                    <button type="submit" class="admin-btn admin-btn--primary admin-btn--block">Simpan Produk</button>
                </div>

                <div class="admin-card">
                    <h3 class="admin-card__title">Kategori</h3>

                    <div class="admin-form-group">
                        <select name="category_id" class="admin-input" required>
                            <option value="">— Pilih Kategori —</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="admin-card">
                    <h3 class="admin-card__title">Thumbnail</h3>

                    <div class="admin-form-group">
                        <div class="admin-upload">
                            <img id="preview-create-my-product" class="admin-upload__preview" style="display:none;">
                            <div id="preview-create-my-product-placeholder" class="admin-upload__placeholder">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3 3.75h18v16.5H3V3.75Z" /></svg>
                                <span>Klik untuk upload gambar</span>
                            </div>
                        </div>
                        <input type="file" name="thumbnail" accept="image/*" class="admin-input" data-image-preview="preview-create-my-product" required>
                        <p class="admin-form-hint">Gambar utama yang tampil di katalog. Maks 2MB.</p>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
