@extends('layouts.admin')

@section('page-title', 'Galeri')

@section('content')
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Galeri Desa</h1>
            <p class="admin-page-subtitle">Dokumentasi kegiatan dan momen penting Desa Dadapan</p>
        </div>
        <button type="button" class="admin-btn admin-btn--primary" data-modal-target="create-gallery">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            Tambah Galeri
        </button>
    </div>

    <div class="admin-card">
        <form method="GET" action="{{ route('admin.galleries.index') }}" class="admin-toolbar" id="gallery-filter-form">
            <div class="admin-search">
                <svg class="admin-search__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                <input type="text" name="search" id="gallery-search" value="{{ request('search') }}" placeholder="Cari galeri..." class="admin-search__input">
            </div>
        </form>

        @if ($galleries->isEmpty())
            <div class="admin-empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3 3.75h18v16.5H3V3.75Z" /></svg>
                <p>Belum ada galeri. Tambahkan dokumentasi kegiatan desa pertama.</p>
            </div>
        @else
            <div class="admin-gallery-grid">
                @foreach ($galleries as $item)
                    <div class="admin-gallery-card">
                        <div class="admin-gallery-card__image-wrap">
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="admin-gallery-card__image">
                            <div class="admin-gallery-card__overlay">
                                <button type="button" class="admin-icon-btn admin-icon-btn--light" data-modal-target="view-gallery-{{ $item->id }}" aria-label="Lihat">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                </button>
                                <button type="button" class="admin-icon-btn admin-icon-btn--light" data-modal-target="edit-gallery-{{ $item->id }}" aria-label="Edit">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 18.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Z" /></svg>
                                </button>
                                <button type="button" class="admin-icon-btn admin-icon-btn--light admin-icon-btn--danger" data-modal-target="delete-gallery-{{ $item->id }}" aria-label="Hapus">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                                </button>
                            </div>
                        </div>
                        <div class="admin-gallery-card__body">
                            <h4 class="admin-gallery-card__title">{{ $item->title }}</h4>
                            <p class="admin-gallery-card__meta">{{ $item->event_date->translatedFormat('d M Y') }}</p>
                            @if ($item->caption)
                                <p class="admin-gallery-card__caption">{{ Str::limit($item->caption, 60) }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="admin-pagination">
                {{ $galleries->links() }}
            </div>
        @endif
    </div>

    {{-- Modal: Tambah Galeri --}}
    <form method="POST" action="{{ route('admin.galleries.store') }}" enctype="multipart/form-data">
        @csrf
        <x-modal id="create-gallery" title="Tambah Galeri" size="md">
            <div class="admin-form-group">
                <label>Gambar</label>
                <div class="admin-upload">
                    <img id="preview-create-gallery" class="admin-upload__preview" style="display:none;">
                    <div id="preview-create-gallery-placeholder" class="admin-upload__placeholder">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3 3.75h18v16.5H3V3.75Z" /></svg>
                        <span>Klik untuk upload gambar</span>
                    </div>
                </div>
                <input type="file" name="image" accept="image/*" class="admin-input" data-image-preview="preview-create-gallery" required>
            </div>

            <div class="admin-form-group">
                <label>Judul</label>
                <input type="text" name="title" class="admin-input" placeholder="Contoh: HUT Kemerdekaan RI ke-81" required>
            </div>

            <div class="admin-form-row">
                <div class="admin-form-group">
                    <label>Tanggal Kegiatan</label>
                    <input type="date" name="event_date" class="admin-input" required>
                </div>
                <div class="admin-form-group">
                    <label>Caption Singkat</label>
                    <input type="text" name="caption" class="admin-input" placeholder="Opsional" maxlength="255">
                </div>
            </div>

            <div class="admin-form-group">
                <label>Deskripsi</label>
                <textarea name="description" rows="3" class="admin-input" placeholder="Opsional"></textarea>
            </div>

            <x-slot name="footer">
                <button type="button" class="admin-btn admin-btn--ghost" data-modal-close>Batal</button>
                <button type="submit" class="admin-btn admin-btn--primary">Simpan</button>
            </x-slot>
        </x-modal>
    </form>

    {{-- Modal: View, Edit, Delete per item --}}
    @foreach ($galleries as $item)
        <x-modal id="view-gallery-{{ $item->id }}" title="Detail Galeri">
            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="admin-modal__preview-image">
            <h4 class="admin-modal__preview-title">{{ $item->title }}</h4>
            <div class="admin-modal__meta">
                <span>{{ $item->event_date->translatedFormat('d M Y') }}</span>
            </div>
            @if ($item->caption)
                <p class="admin-modal__content"><strong>{{ $item->caption }}</strong></p>
            @endif
            @if ($item->description)
                <p class="admin-modal__content">{{ $item->description }}</p>
            @endif
        </x-modal>

        <form method="POST" action="{{ route('admin.galleries.update', $item) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <x-modal id="edit-gallery-{{ $item->id }}" title="Edit Galeri" size="md">
                <div class="admin-form-group">
                    <label>Gambar (kosongkan jika tidak diganti)</label>
                    <div class="admin-upload">
                        <img id="preview-edit-gallery-{{ $item->id }}" class="admin-upload__preview" src="{{ asset('storage/' . $item->image) }}" style="display:block;">
                        <div id="preview-edit-gallery-{{ $item->id }}-placeholder" class="admin-upload__placeholder" style="display:none;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3 3.75h18v16.5H3V3.75Z" /></svg>
                            <span>Klik untuk upload gambar</span>
                        </div>
                    </div>
                    <input type="file" name="image" accept="image/*" class="admin-input" data-image-preview="preview-edit-gallery-{{ $item->id }}">
                </div>

                <div class="admin-form-group">
                    <label>Judul</label>
                    <input type="text" name="title" value="{{ $item->title }}" class="admin-input" required>
                </div>

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label>Tanggal Kegiatan</label>
                        <input type="date" name="event_date" value="{{ $item->event_date->format('Y-m-d') }}" class="admin-input" required>
                    </div>
                    <div class="admin-form-group">
                        <label>Caption Singkat</label>
                        <input type="text" name="caption" value="{{ $item->caption }}" class="admin-input" maxlength="255">
                    </div>
                </div>

                <div class="admin-form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" rows="3" class="admin-input">{{ $item->description }}</textarea>
                </div>

                <x-slot name="footer">
                    <button type="button" class="admin-btn admin-btn--ghost" data-modal-close>Batal</button>
                    <button type="submit" class="admin-btn admin-btn--primary">Simpan Perubahan</button>
                </x-slot>
            </x-modal>
        </form>

        <x-delete-modal
            id="delete-gallery-{{ $item->id }}"
            :action="route('admin.galleries.destroy', $item)"
            :message="'Galeri &quot;' . $item->title . '&quot; akan dihapus permanen beserta gambarnya.'" />
    @endforeach

    @push('scripts')
        <script>
            const gallerySearch = document.getElementById('gallery-search');
            const galleryForm = document.getElementById('gallery-filter-form');
            let galleryDebounce;

            gallerySearch?.addEventListener('input', () => {
                clearTimeout(galleryDebounce);
                galleryDebounce = setTimeout(() => galleryForm.submit(), 400);
            });
        </script>
    @endpush
@endsection
