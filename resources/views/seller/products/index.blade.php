@extends('layouts.seller')

@section('page-title', 'Produk')

@section('content')
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Produk Saya</h1>
            <p class="admin-page-subtitle">Kelola produk UMKM yang Anda jual</p>
        </div>
        <a href="{{ route('seller.products.create') }}" class="admin-btn admin-btn--primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            Tambah Produk
        </a>
    </div>

    <div class="admin-card">
        <form method="GET" action="{{ route('seller.products.index') }}" class="admin-toolbar" id="my-product-filter-form">
            <div class="admin-search">
                <svg class="admin-search__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                <input type="text" name="search" id="my-product-search" value="{{ request('search') }}" placeholder="Cari produk saya..." class="admin-search__input">
            </div>
            <select name="status" id="my-product-status-filter" class="admin-select">
                <option value="all" @selected(request('status', 'all') === 'all')>Semua Status</option>
                <option value="active" @selected(request('status') === 'active')>Aktif</option>
                <option value="inactive" @selected(request('status') === 'inactive')>Nonaktif</option>
            </select>
        </form>

        @if ($products->isEmpty())
            <div class="admin-empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5v9l-9 5.25L3 16.5v-9L12 2.25 21 7.5Zm0 0L12 12.75m0 0L3 7.5m9 5.25v9" /></svg>
                <p>Belum ada produk. Yuk tambahkan produk pertama Anda!</p>
            </div>
        @else
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $index => $product)
                            @php
                                $badgeColors = ['badge-teal', 'badge-amber', 'badge-purple', 'badge-pink', 'badge-blue', 'badge-orange'];
                                $badgeClass = $badgeColors[$product->category_id % count($badgeColors)];
                            @endphp
                            <tr>
                                <td>{{ $products->firstItem() + $index }}</td>
                                <td>
                                    <div class="admin-table__media">
                                        <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}">
                                        <span>{{ $product->name }}</span>
                                    </div>
                                </td>
                                <td><span class="admin-badge {{ $badgeClass }}">{{ $product->category->name }}</span></td>
                                <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>
                                    @if ($product->stock <= 5)
                                        <span class="admin-badge admin-badge--warning">{{ $product->stock }} tersisa</span>
                                    @else
                                        {{ $product->stock }}
                                    @endif
                                </td>
                                <td>
                                    @if ($product->status)
                                        <span class="admin-badge admin-badge--success">Aktif</span>
                                    @else
                                        <span class="admin-badge admin-badge--muted">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="admin-table__actions">
                                        <button type="button" class="admin-icon-btn" data-modal-target="view-my-product-{{ $product->id }}" aria-label="Lihat">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                        </button>
                                        <button type="button" class="admin-icon-btn" data-modal-target="edit-my-product-{{ $product->id }}" aria-label="Edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 18.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Z" /></svg>
                                        </button>
                                        <button type="button" class="admin-icon-btn admin-icon-btn--danger" data-modal-target="delete-my-product-{{ $product->id }}" aria-label="Hapus">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="admin-pagination">{{ $products->links() }}</div>
        @endif
    </div>

    {{-- Modal View, Edit, Delete per produk --}}
    @foreach ($products as $product)
        <x-modal id="view-my-product-{{ $product->id }}" title="Detail Produk" size="lg">
            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="admin-modal__preview-image">

            @if ($product->images->isNotEmpty())
                <div class="admin-image-strip">
                    @foreach ($product->images as $img)
                        <img src="{{ asset('storage/' . $img->image_url) }}" alt="Galeri produk">
                    @endforeach
                </div>
            @endif

            <h4 class="admin-modal__preview-title">{{ $product->name }}</h4>
            <div class="admin-modal__meta">
                <span>{{ $product->category->name }}</span>
                <span>•</span>
                <span>Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                <span>•</span>
                <span>Stok: {{ $product->stock }}</span>
            </div>
            <div class="admin-modal__content">{{ $product->description }}</div>
        </x-modal>

        <form method="POST" action="{{ route('seller.products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <x-modal id="edit-my-product-{{ $product->id }}" title="Edit Produk" size="lg">
                <div class="admin-form-group">
                    <label>Nama Produk</label>
                    <input type="text" name="name" value="{{ $product->name }}" class="admin-input" required>
                </div>

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label>Kategori</label>
                        <select name="category_id" class="admin-input" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected($product->category_id == $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="admin-form-group">
                        <label>Status</label>
                        <select name="status" class="admin-input">
                            <option value="1" @selected($product->status)>Aktif</option>
                            <option value="0" @selected(!$product->status)>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label>Harga (Rp)</label>
                        <input type="number" name="price" value="{{ $product->price }}" class="admin-input" min="0" required>
                    </div>
                    <div class="admin-form-group">
                        <label>Stok</label>
                        <input type="number" name="stock" value="{{ $product->stock }}" class="admin-input" min="0" required>
                    </div>
                </div>

                <div class="admin-form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" rows="4" class="admin-input" required>{{ $product->description }}</textarea>
                </div>

                <div class="admin-form-group">
                    <label>Ganti Thumbnail (kosongkan jika tidak diganti)</label>
                    <input type="file" name="thumbnail" accept="image/*" class="admin-input">
                </div>

                @if ($product->images->isNotEmpty())
                    <div class="admin-form-group">
                        <label>Gambar Tambahan</label>
                        <div class="admin-image-manage">
                            @foreach ($product->images as $img)
                                <div class="admin-image-manage__item">
                                    <img src="{{ asset('storage/' . $img->image_url) }}" alt="Galeri produk">
                                    <button type="submit" form="delete-my-image-form-{{ $img->id }}" class="admin-image-manage__remove" aria-label="Hapus gambar">×</button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="admin-form-group">
                    <label>Tambah Gambar Baru</label>
                    <input type="file" name="images[]" accept="image/*" class="admin-input" multiple>
                </div>

                <x-slot name="footer">
                    <button type="button" class="admin-btn admin-btn--ghost" data-modal-close>Batal</button>
                    <button type="submit" class="admin-btn admin-btn--primary">Simpan Perubahan</button>
                </x-slot>
            </x-modal>
        </form>

        @foreach ($product->images as $img)
            <form id="delete-my-image-form-{{ $img->id }}" method="POST" action="{{ route('seller.products.images.destroy', [$product, $img]) }}">
                @csrf
                @method('DELETE')
            </form>
        @endforeach

        <x-delete-modal
            id="delete-my-product-{{ $product->id }}"
            :action="route('seller.products.destroy', $product)"
            :message="'Produk &quot;' . $product->name . '&quot; akan dihapus permanen beserta seluruh gambarnya.'" />
    @endforeach

    @push('scripts')
        <script>
            const myProductSearch = document.getElementById('my-product-search');
            const myProductForm = document.getElementById('my-product-filter-form');
            let myProductDebounce;

            myProductSearch?.addEventListener('input', () => {
                clearTimeout(myProductDebounce);
                myProductDebounce = setTimeout(() => myProductForm.submit(), 400);
            });

            document.getElementById('my-product-status-filter')?.addEventListener('change', () => myProductForm.submit());
        </script>
    @endpush
@endsection
