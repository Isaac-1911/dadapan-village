@extends('layouts.admin')

@section('page-title', 'Tulis Berita')

@section('content')
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Tulis Berita</h1>
            <p class="admin-page-subtitle">Tambahkan berita atau informasi resmi Desa Dadapan</p>
        </div>
        <a href="{{ route('admin.news.index') }}" class="admin-btn admin-btn--ghost">
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

    <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="admin-form-grid">
            {{-- Kolom kiri: konten utama --}}
            <div class="admin-card">
                <div class="admin-form-group">
                    <label>Judul Berita</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="admin-input" placeholder="Contoh: HUT ke-78 Desa Dadapan Berlangsung Meriah" required>
                </div>

                <div class="admin-form-group">
                    <label>Isi Berita</label>
                    <textarea name="content" rows="12" class="admin-input" placeholder="Tulis isi berita di sini..." required>{{ old('content') }}</textarea>
                </div>
            </div>

            {{-- Kolom kanan: metadata & publish --}}
            <div class="admin-form-sidebar">
                <div class="admin-card">
                    <h3 class="admin-card__title">Publikasi</h3>

                    <div class="admin-form-group">
                        <label>Status</label>
                        <select name="status" class="admin-input">
                            <option value="0" @selected(old('status', '0') === '0')>Draft</option>
                            <option value="1" @selected(old('status') === '1')>Terbit</option>
                        </select>
                    </div>

                    <div class="admin-form-group">
                        <label>Tanggal Terbit</label>
                        <input type="date" name="published_at" value="{{ old('published_at', now()->format('Y-m-d')) }}" class="admin-input">
                        <p class="admin-form-hint">Diabaikan kalau status Draft.</p>
                    </div>

                    <button type="submit" class="admin-btn admin-btn--primary admin-btn--block">
                        Simpan Berita
                    </button>
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
                        <div class="admin-upload" id="thumbnail-preview-wrap">
                            <img id="thumbnail-preview" class="admin-upload__preview" style="display:none;">
                            <div id="thumbnail-placeholder" class="admin-upload__placeholder">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3 3.75h18v16.5H3V3.75Z" /></svg>
                                <span>Klik untuk upload gambar</span>
                            </div>
                        </div>
                        <input type="file" name="thumbnail" id="thumbnail-input" accept="image/*" class="admin-input">
                        <p class="admin-form-hint">Format JPG/PNG, maks 2MB.</p>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @push('scripts')
        <script>
            const thumbInput = document.getElementById('thumbnail-input');
            const thumbPreview = document.getElementById('thumbnail-preview');
            const thumbPlaceholder = document.getElementById('thumbnail-placeholder');

            thumbInput?.addEventListener('change', () => {
                const file = thumbInput.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = (e) => {
                    thumbPreview.src = e.target.result;
                    thumbPreview.style.display = 'block';
                    thumbPlaceholder.style.display = 'none';
                };
                reader.readAsDataURL(file);
            });
        </script>
    @endpush
@endsection
