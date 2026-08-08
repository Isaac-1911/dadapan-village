@php
    $sellerName = auth()->user()->sellerProfile->owner_name ?? auth()->user()->name;
    $sellerInitials = collect(explode(' ', $sellerName))
        ->map(fn($word) => strtoupper(substr($word, 0, 1)))
        ->take(2)
        ->implode('');
@endphp

<aside id="admin-sidebar" class="admin-sidebar">

    <div class="admin-sidebar__header">
        <a href="{{ route('seller.dashboard') }}" class="admin-sidebar__brand">
            <span class="admin-sidebar__logo">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.5 1.5 0 0 1 2.122 0l8.954 8.955M4.5 9.75v9.75a1.5 1.5 0 0 0 1.5 1.5h3v-6h6v6h3a1.5 1.5 0 0 0 1.5-1.5V9.75" /></svg>
            </span>
            <span class="admin-sidebar__brand-text">
                <span class="admin-sidebar__brand-title">Dadapan Village</span>
                <span class="admin-sidebar__brand-subtitle admin-sidebar__brand-subtitle--accent">Portal UMKM</span>
            </span>
        </a>
        {{--   --}}
    </div>

    <nav class="admin-sidebar__nav">
        <p class="admin-nav-section-label">Menu Utama</p>

        <a href="{{ route('seller.dashboard') }}" class="admin-nav-link {{ request()->routeIs('seller.dashboard') ? 'admin-nav-link--active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" /></svg>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('seller.profile.edit') }}" class="admin-nav-link {{ request()->routeIs('seller.profile.*') ? 'admin-nav-link--active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.5 1.5 0 0 1 2.122 0l8.954 8.955M4.5 9.75v9.75a1.5 1.5 0 0 0 1.5 1.5h3v-6h6v6h3a1.5 1.5 0 0 0 1.5-1.5V9.75" /></svg>
            <span>Profil UMKM</span>
        </a>

        <a href="{{ Route::has('seller.products.index') ? route('seller.products.index') : '#' }}" class="admin-nav-link {{ request()->routeIs('seller.products.*') ? 'admin-nav-link--active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5v9l-9 5.25L3 16.5v-9L12 2.25 21 7.5Zm0 0L12 12.75m0 0L3 7.5m9 5.25v9" /></svg>
            <span>Produk</span>
        </a>
    </nav>

    <div class="admin-sidebar__footer">
        <div class="admin-sidebar__profile-card">
            <span class="admin-topbar__avatar">{{ $sellerInitials }}</span>
            <div class="admin-sidebar__profile-info">
                <span class="admin-sidebar__profile-name">{{ $sellerName }}</span>
                <span class="admin-sidebar__profile-role">Pemilik UMKM</span>
            </div>
        </div>

        <button type="button" class="admin-nav-link admin-nav-link--danger" data-modal-target="logout-confirm">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" /></svg>
            <span>Keluar</span>
        </button>
    </div>

</aside>

<div id="sidebar-overlay" class="admin-sidebar-overlay"></div>

<x-modal id="logout-confirm" title="Konfirmasi Keluar" size="sm">
    <p class="admin-modal__text">Apakah Anda yakin ingin keluar dari portal?</p>

    <x-slot name="footer">
        <button type="button" class="admin-btn admin-btn--ghost" data-modal-close>Batal</button>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="admin-btn admin-btn--danger">Ya, Keluar</button>
        </form>
    </x-slot>
</x-modal>
