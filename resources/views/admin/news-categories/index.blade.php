@extends('layouts.admin')

@section('page-title', 'Kategori Berita')

@section('content')
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Kategori Berita</h1>
            <p class="admin-page-subtitle">Kelola kategori untuk pengelompokan berita desa</p>
        </div>
        <button type="button" class="admin-btn admin-btn--primary" data-modal-target="create-news-category">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            Tambah Kategori
        </button>
    </div>

    <div class="admin-card">
        <form method="GET" action="{{ route('admin.news-categories.index') }}" class="admin-toolbar" id="category-filter-form">
            <div class="admin-search">
                <svg class="admin-search__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                <input type="text" name="search" id="category-search" value="{{ request('search') }}" placeholder="Cari kategori..." class="admin-search__input">
            </div>
        </form>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Kategori</th>
                        <th>Slug</th>
                        <th>Jumlah Berita</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $index => $category)
                        <tr>
                            <td>{{ $categories->firstItem() + $index }}</td>
                            <td>{{ $category->name }}</td>
                            <td><code class="admin-code">{{ $category->slug }}</code></td>
                            <td>{{ $category->news_count }} berita</td>
                            <td>
                                <div class="admin-table__actions">
                                    <button type="button" class="admin-icon-btn" data-modal-target="edit-news-category-{{ $category->id }}" aria-label="Edit">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 18.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Z" /></svg>
                                    </button>
                                    <button type="button" class="admin-icon-btn admin-icon-btn--danger" data-modal-target="delete-news-category-{{ $category->id }}" aria-label="Hapus">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="admin-table__empty">Belum ada kategori berita.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-pagination">
            {{ $categories->links() }}
        </div>
    </div>

    {{-- Modal: Tambah Kategori --}}
    <form method="POST" action="{{ route('admin.news-categories.store') }}">
        @csrf
        <x-modal id="create-news-category" title="Tambah Kategori Berita" size="sm">
            <div class="admin-form-group">
                <label>Nama Kategori</label>
                <input type="text" name="name" class="admin-input" placeholder="Contoh: Pengumuman" required autofocus>
            </div>

            <x-slot name="footer">
                <button type="button" class="admin-btn admin-btn--ghost" data-modal-close>Batal</button>
                <button type="submit" class="admin-btn admin-btn--primary">Simpan</button>
            </x-slot>
        </x-modal>
    </form>

    {{-- Modal: Edit & Delete per kategori --}}
    @foreach ($categories as $category)
        <form method="POST" action="{{ route('admin.news-categories.update', $category) }}">
            @csrf
            @method('PUT')
            <x-modal id="edit-news-category-{{ $category->id }}" title="Edit Kategori Berita" size="sm">
                <div class="admin-form-group">
                    <label>Nama Kategori</label>
                    <input type="text" name="name" value="{{ $category->name }}" class="admin-input" required>
                </div>

                <x-slot name="footer">
                    <button type="button" class="admin-btn admin-btn--ghost" data-modal-close>Batal</button>
                    <button type="submit" class="admin-btn admin-btn--primary">Simpan Perubahan</button>
                </x-slot>
            </x-modal>
        </form>

        <x-delete-modal
            id="delete-news-category-{{ $category->id }}"
            :action="route('admin.news-categories.destroy', $category)"
            :message="'Kategori &quot;' . $category->name . '&quot; akan dihapus permanen. Kategori yang masih dipakai berita tidak bisa dihapus.'" />
    @endforeach

    @push('scripts')
        <script>
            const catSearch = document.getElementById('category-search');
            const catForm = document.getElementById('category-filter-form');
            let catDebounce;

            catSearch?.addEventListener('input', () => {
                clearTimeout(catDebounce);
                catDebounce = setTimeout(() => catForm.submit(), 400);
            });
        </script>
    @endpush
@endsection
