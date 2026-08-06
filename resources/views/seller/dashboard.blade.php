@extends('layouts.seller')

@section('page-title', 'Dashboard')

@section('content')
    {{-- WELCOME BANNER --}}
    <div class="seller-hero">
        <span class="seller-hero__eyebrow">Selamat Datang</span>
        <h1 class="seller-hero__title">Halo, {{ $sellerProfile->owner_name }}!</h1>
        {{-- <p class="seller-hero__subtitle">Kelola produk UMKM Anda dengan mudah melalui portal ini.</p> --}}

        <div class="seller-hero__actions">
            <a href="{{ Route::has('seller.products.create') ? route('seller.products.create') : '#' }}" class="admin-btn seller-hero__btn seller-hero__btn--primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Tambah Produk
            </a>
            <a href="{{ route('seller.profile.edit') }}" class="admin-btn seller-hero__btn seller-hero__btn--ghost">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 18.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Z" /></svg>
                Edit Profil Usaha
            </a>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="admin-stat-grid">
        <div class="admin-card admin-stat-card">
            <div class="admin-stat-card__top">
                <span class="admin-stat-card__label">Total Produk</span>
                <span class="admin-stat-card__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5v9l-9 5.25L3 16.5v-9L12 2.25 21 7.5Zm0 0L12 12.75m0 0L3 7.5m9 5.25v9" /></svg>
                </span>
            </div>
            <div class="admin-stat-card__value">{{ $totalProducts }}</div>
            <div class="admin-stat-card__trend admin-stat-card__trend--up">+{{ $newThisMonth }} bulan ini</div>
        </div>

        <div class="admin-card admin-stat-card">
            <div class="admin-stat-card__top">
                <span class="admin-stat-card__label">Produk Aktif</span>
                <span class="admin-stat-card__icon admin-stat-card__icon--success">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                </span>
            </div>
            <div class="admin-stat-card__value">{{ $activeProducts }}</div>
            <div class="admin-stat-card__trend">{{ $activePercentage }}% dari total</div>
        </div>

        <div class="admin-card admin-stat-card">
            <div class="admin-stat-card__top">
                <span class="admin-stat-card__label">Stok Habis</span>
                <span class="admin-stat-card__icon admin-stat-card__icon--danger">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" /></svg>
                </span>
            </div>
            <div class="admin-stat-card__value">{{ $outOfStock }}</div>
            <div class="admin-stat-card__trend admin-stat-card__trend--down">Perlu restock</div>
        </div>

        <div class="admin-card admin-stat-card">
            <div class="admin-stat-card__top">
                <span class="admin-stat-card__label">Kategori Produk</span>
                <span class="admin-stat-card__icon admin-stat-card__icon--warning">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.83.699 2.528 0l4.318-4.318a1.79 1.79 0 0 0 0-2.528L10.5 3.66A2.25 2.25 0 0 0 9.568 3Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" /></svg>
                </span>
            </div>
            <div class="admin-stat-card__value">{{ $categoryCount }}</div>
            <div class="admin-stat-card__trend">Beragam kategori</div>
        </div>
    </div>

    {{-- CHART & AKTIVITAS TERKINI --}}
    <div class="admin-dashboard-grid admin-dashboard-grid--2-1">
        <div class="admin-card">
            <h3 class="admin-card__title">Upload Produk Bulanan</h3>
            <p class="admin-card__subtitle">Jumlah produk yang diunggah per bulan</p>
            <canvas id="sellerProductChart" height="90"></canvas>
        </div>

        <div class="admin-card">
            <h3 class="admin-card__title">Aktivitas Terkini</h3>
            <div class="admin-timeline">
                @forelse ($activity as $item)
                    <div class="admin-timeline__item">
                        <span class="admin-timeline__dot admin-timeline__dot--{{ $item['type'] }}"></span>
                        <div class="admin-timeline__body">
                            <span class="admin-timeline__label">{{ $item['label'] }}</span>
                            <span class="admin-timeline__time">{{ $item['time']->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <p class="admin-list__empty">Belum ada aktivitas.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- PRODUK TERBARU & INFORMASI USAHA --}}
    <div class="admin-dashboard-grid admin-dashboard-grid--2">
        <div class="admin-card">
            <h3 class="admin-card__title">Produk Terbaru</h3>
            <div class="admin-list">
                @forelse ($recentProducts as $product)
                    <div class="admin-list__item">
                        <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="admin-list__thumb">
                        <div class="admin-list__body">
                            <span class="admin-list__title">{{ $product->name }}</span>
                            <span class="admin-list__meta">{{ $product->category->name }} • Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                        @if ($product->stock == 0)
                            <span class="admin-badge admin-badge--warning">Stok habis</span>
                        @elseif ($product->status)
                            <span class="admin-badge admin-badge--success">Aktif</span>
                        @else
                            <span class="admin-badge admin-badge--muted">Draft</span>
                        @endif
                    </div>
                @empty
                    <p class="admin-list__empty">Belum ada produk. Yuk tambahkan produk pertama Anda!</p>
                @endforelse
            </div>
        </div>

        <div class="admin-card">
            <h3 class="admin-card__title">Informasi Usaha</h3>
            <div class="seller-info">
                @if ($sellerProfile->logo)
                    <img src="{{ asset('storage/' . $sellerProfile->logo) }}" alt="{{ $sellerProfile->business_name }}" class="seller-info__logo">
                @endif
                <div class="seller-info__body">
                    <span class="seller-info__name">{{ $sellerProfile->business_name }}</span>
                    <span class="seller-info__owner">{{ $sellerProfile->owner_name }}</span>
                </div>
            </div>

            <div class="seller-info__details">
                <div class="seller-info__row">
                    <span class="seller-info__label">WhatsApp</span>
                    <span class="seller-info__value">{{ $sellerProfile->whatsapp }}</span>
                </div>
                <div class="seller-info__row">
                    <span class="seller-info__label">Alamat</span>
                    <span class="seller-info__value">{{ $sellerProfile->address }}</span>
                </div>
            </div>

            <a href="{{ route('seller.profile.edit') }}" class="admin-btn admin-btn--ghost admin-btn--block">Edit Profil Usaha</a>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            new Chart(document.getElementById('sellerProductChart'), {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        data: @json($chartData),
                        borderColor: '#0f766e',
                        backgroundColor: 'rgba(15, 118, 110, 0.08)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#0f766e',
                        pointRadius: 4,
                    }],
                },
                options: {
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, grid: { color: '#f3f4f6' } }, x: { grid: { display: false } } },
                },
            });
        </script>
    @endpush
@endsection
