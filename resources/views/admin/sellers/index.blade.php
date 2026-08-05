@extends('layouts.admin')

@section('page-title', 'Penjual / UMKM')

@section('content')
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Penjual / UMKM</h1>
            <p class="admin-page-subtitle">Kelola akun seller dan profil UMKM Desa Dadapan</p>
        </div>
        <a href="{{ route('admin.sellers.create') }}" class="admin-btn admin-btn--primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            Tambah Seller
        </a>
    </div>

    <div class="admin-card">
        <form method="GET" action="{{ route('admin.sellers.index') }}" class="admin-toolbar" id="seller-filter-form">
            <div class="admin-search">
                <svg class="admin-search__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                <input type="text" name="search" id="seller-search" value="{{ request('search') }}" placeholder="Cari seller..." class="admin-search__input">
            </div>
            <select name="status" id="seller-status-filter" class="admin-select">
                <option value="all" @selected(request('status', 'all') === 'all')>Semua Status</option>
                <option value="active" @selected(request('status') === 'active')>Aktif</option>
                <option value="inactive" @selected(request('status') === 'inactive')>Nonaktif</option>
            </select>
        </form>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>UMKM</th>
                        <th>Pemilik</th>
                        <th>WhatsApp</th>
                        <th>Produk</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sellers as $index => $seller)
                        <tr>
                            <td>{{ $sellers->firstItem() + $index }}</td>
                            <td>
                                <div class="admin-table__media">
                                    <img src="{{ $seller->logo ? asset('storage/' . $seller->logo) : asset('images/placeholder-logo.png') }}" alt="{{ $seller->business_name }}">
                                    <span>{{ $seller->business_name }}</span>
                                </div>
                            </td>
                            <td>{{ $seller->owner_name }}</td>
                            <td>{{ $seller->whatsapp }}</td>
                            <td>{{ $seller->products_count }} produk</td>
                            <td>
                                @if ($seller->user->is_active)
                                    <span class="admin-badge admin-badge--success">Aktif</span>
                                @else
                                    <span class="admin-badge admin-badge--muted">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="admin-table__actions">
                                    <button type="button" class="admin-icon-btn" data-modal-target="view-seller-{{ $seller->id }}" aria-label="Lihat">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                    </button>
                                    <button type="button" class="admin-icon-btn" data-modal-target="edit-seller-{{ $seller->id }}" aria-label="Edit">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 18.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Z" /></svg>
                                    </button>
                                    <form method="POST" action="{{ route('admin.sellers.toggle-status', $seller) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="admin-icon-btn" aria-label="{{ $seller->user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1 0 12.728 0M12 3v9" /></svg>
                                        </button>
                                    </form>
                                    <button type="button" class="admin-icon-btn admin-icon-btn--danger" data-modal-target="delete-seller-{{ $seller->id }}" aria-label="Hapus">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="admin-table__empty">Belum ada seller terdaftar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-pagination">{{ $sellers->links() }}</div>
    </div>

    {{-- Modal View, Edit, Delete per seller --}}
    @foreach ($sellers as $seller)
        <x-modal id="view-seller-{{ $seller->id }}" title="Detail Seller">
            @if ($seller->logo)
                <img src="{{ asset('storage/' . $seller->logo) }}" alt="{{ $seller->business_name }}" class="admin-modal__preview-image">
            @endif
            <h4 class="admin-modal__preview-title">{{ $seller->business_name }}</h4>
            <div class="admin-modal__meta">
                <span>{{ $seller->owner_name }}</span>
                <span>•</span>
                <span>{{ $seller->whatsapp }}</span>
            </div>
            <p class="admin-modal__content"><strong>Email:</strong> {{ $seller->user->email }}</p>
            @if ($seller->user->phone)
                <p class="admin-modal__content"><strong>Telepon:</strong> {{ $seller->user->phone }}</p>
            @endif
            <p class="admin-modal__content"><strong>Alamat:</strong> {{ $seller->address }}</p>
            @if ($seller->description)
                <p class="admin-modal__content">{{ $seller->description }}</p>
            @endif
        </x-modal>

        <form method="POST" action="{{ route('admin.sellers.update', $seller) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <x-modal id="edit-seller-{{ $seller->id }}" title="Edit Seller" size="lg">
                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label>Nama Akun</label>
                        <input type="text" name="name" value="{{ $seller->user->name }}" class="admin-input" required>
                    </div>
                    <div class="admin-form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ $seller->user->email }}" class="admin-input" required>
                    </div>
                </div>

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label>Nama Usaha</label>
                        <input type="text" name="business_name" value="{{ $seller->business_name }}" class="admin-input" required>
                    </div>
                    <div class="admin-form-group">
                        <label>Nama Pemilik</label>
                        <input type="text" name="owner_name" value="{{ $seller->owner_name }}" class="admin-input" required>
                    </div>
                </div>

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label>Nomor WhatsApp</label>
                        <input type="text" name="whatsapp" value="{{ $seller->whatsapp }}" class="admin-input" required>
                    </div>
                    <div class="admin-form-group">
                        <label>Telepon (opsional)</label>
                        <input type="text" name="phone" value="{{ $seller->user->phone }}" class="admin-input">
                    </div>
                </div>

                <div class="admin-form-group">
                    <label>Alamat</label>
                    <textarea name="address" rows="2" class="admin-input" required>{{ $seller->address }}</textarea>
                </div>

                <div class="admin-form-group">
                    <label>Deskripsi Usaha</label>
                    <textarea name="description" rows="3" class="admin-input">{{ $seller->description }}</textarea>
                </div>

                <div class="admin-form-group">
                    <label>Ganti Logo (kosongkan jika tidak diganti)</label>
                    <input type="file" name="logo" accept="image/*" class="admin-input">
                </div>

                <x-slot name="footer">
                    <button type="button" class="admin-btn admin-btn--ghost" data-modal-close>Batal</button>
                    <button type="submit" class="admin-btn admin-btn--primary">Simpan Perubahan</button>
                </x-slot>
            </x-modal>
        </form>

        <x-delete-modal
            id="delete-seller-{{ $seller->id }}"
            :action="route('admin.sellers.destroy', $seller)"
            :message="'Seller &quot;' . $seller->business_name . '&quot; beserta akunnya akan dihapus permanen. Seller yang masih punya produk tidak bisa dihapus.'" />
    @endforeach

    @push('scripts')
        <script>
            const sellerSearch = document.getElementById('seller-search');
            const sellerForm = document.getElementById('seller-filter-form');
            let sellerDebounce;

            sellerSearch?.addEventListener('input', () => {
                clearTimeout(sellerDebounce);
                sellerDebounce = setTimeout(() => sellerForm.submit(), 400);
            });

            document.getElementById('seller-status-filter')?.addEventListener('change', () => sellerForm.submit());
        </script>
    @endpush
@endsection
