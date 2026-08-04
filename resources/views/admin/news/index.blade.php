@extends('layouts.admin')

@section('page-title', 'Semua Berita')

@section('content')
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Manajemen Berita</h1>
            <p class="admin-page-subtitle">Kelola berita dan informasi resmi Desa Dadapan</p>
        </div>
        <a href="{{ route('admin.news.create') }}" class="admin-btn admin-btn--primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            Tulis Berita
        </a>
    </div>

    <div class="admin-card">
        <form method="GET" action="{{ route('admin.news.index') }}" id="news-filter-form" class="admin-toolbar">
            <div class="admin-search">
                <svg class="admin-search__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                <input type="text" name="search" id="news-search" value="{{ request('search') }}" placeholder="Cari berita..." class="admin-search__input">
            </div>

            <select name="status" id="news-status-filter" class="admin-select">
                <option value="all" @selected(request('status', 'all') === 'all')>Semua</option>
                <option value="published" @selected(request('status') === 'published')>Terbit</option>
                <option value="draft" @selected(request('status') === 'draft')>Draft</option>
            </select>
        </form>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Berita</th>
                        <th>Kategori</th>
                        <th>Penulis</th>
                        <th>Status</th>
                        <th>Tgl Terbit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($news as $index => $item)
                        @php
                            $badgeColors = ['badge-teal', 'badge-amber', 'badge-purple', 'badge-pink', 'badge-blue', 'badge-orange'];
                            $badgeClass = $badgeColors[$item->category_id % count($badgeColors)];
                        @endphp
                        <tr>
                            <td>{{ $news->firstItem() + $index }}</td>
                            <td>
                                <div class="admin-table__media">
                                    <img src="{{ $item->thumbnail ? asset('storage/' . $item->thumbnail) : asset('images/placeholder-news.png') }}" alt="{{ $item->title }}">
                                    <span>{{ $item->title }}</span>
                                </div>
                            </td>
                            <td><span class="admin-badge {{ $badgeClass }}">{{ $item->category->name }}</span></td>
                            <td>{{ $item->author->name }}</td>
                            <td>
                                @if ($item->status)
                                    <span class="admin-badge admin-badge--success">Terbit</span>
                                @else
                                    <span class="admin-badge admin-badge--muted">Draft</span>
                                @endif
                            </td>
                            <td>{{ $item->published_at?->translatedFormat('d M Y') ?? '-' }}</td>
                            <td>
                                <div class="admin-table__actions">
                                    <button type="button" class="admin-icon-btn" data-modal-target="view-news-{{ $item->id }}" aria-label="Lihat">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                    </button>
                                    <button type="button" class="admin-icon-btn" data-modal-target="edit-news-{{ $item->id }}" aria-label="Edit">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 18.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Z" /></svg>
                                    </button>
                                    <button type="button" class="admin-icon-btn admin-icon-btn--danger" data-modal-target="delete-news-{{ $item->id }}" aria-label="Hapus">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="admin-table__empty">Belum ada berita.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-pagination">
            {{ $news->links() }}
        </div>
    </div>

    {{-- Modals --}}
    @foreach ($news as $item)
        <x-modal id="view-news-{{ $item->id }}" title="Detail Berita">
            @if ($item->thumbnail)
                <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}" class="admin-modal__preview-image">
            @endif
            <h4 class="admin-modal__preview-title">{{ $item->title }}</h4>
            <div class="admin-modal__meta">
                <span>{{ $item->category->name }}</span>
                <span>•</span>
                <span>{{ $item->author->name }}</span>
                <span>•</span>
                <span>{{ $item->published_at?->translatedFormat('d M Y') ?? 'Belum terbit' }}</span>
            </div>
            <div class="admin-modal__content">{!! nl2br(e($item->content)) !!}</div>
        </x-modal>

        <form method="POST" action="{{ route('admin.news.update', $item) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <x-modal id="edit-news-{{ $item->id }}" title="Edit Berita" size="lg">
                <div class="admin-form-group">
                    <label>Judul Berita</label>
                    <input type="text" name="title" value="{{ $item->title }}" class="admin-input" required>
                </div>

                <div class="admin-form-group">
                    <label>Kategori</label>
                    <select name="category_id" class="admin-input" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected($item->category_id == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="admin-form-group">
                    <label>Isi Berita</label>
                    <textarea name="content" rows="5" class="admin-input" required>{{ $item->content }}</textarea>
                </div>

                <div class="admin-form-group">
                    <label>Thumbnail (kosongkan jika tidak diganti)</label>
                    <input type="file" name="thumbnail" class="admin-input" accept="image/*">
                </div>

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label>Status</label>
                        <select name="status" class="admin-input">
                            <option value="1" @selected($item->status)>Terbit</option>
                            <option value="0" @selected(!$item->status)>Draft</option>
                        </select>
                    </div>
                    <div class="admin-form-group">
                        <label>Tanggal Terbit</label>
                        <input type="date" name="published_at" value="{{ $item->published_at?->format('Y-m-d') }}" class="admin-input">
                    </div>
                </div>

                <x-slot name="footer">
                    <button type="button" class="admin-btn admin-btn--ghost" data-modal-close>Batal</button>
                    <button type="submit" class="admin-btn admin-btn--primary">Simpan Perubahan</button>
                </x-slot>
            </x-modal>
        </form>

        <x-delete-modal
            id="delete-news-{{ $item->id }}"
            :action="route('admin.news.destroy', $item)"
            :message="'Berita &quot;' . $item->title . '&quot; akan dihapus permanen.'" />
    @endforeach

    @push('scripts')
        <script>
            const searchInput = document.getElementById('news-search');
            const statusFilter = document.getElementById('news-status-filter');
            const filterForm = document.getElementById('news-filter-form');
            let debounceTimer;

            searchInput?.addEventListener('input', () => {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => filterForm.submit(), 400);
            });

            statusFilter?.addEventListener('change', () => filterForm.submit());
        </script>
    @endpush
@endsection
