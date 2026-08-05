@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
    {{-- <h1 class="admin-page-title">Selamat Datang, {{ auth()->user()->name }} 👋</h1>
    <p class="admin-page-subtitle">Portal Administrasi Desa Dadapan — {{ now()->translatedFormat('l, j F Y') }}</p> --}}

    {{-- ===== STAT CARDS ===== --}}
    <div class="admin-stat-grid">
        @php
            $statCards = [
                ['label' => 'Total Penjual', 'value' => $stats['sellers']['total'], 'stat' => $stats['sellers'], 'icon' => 'store'],
                ['label' => 'Total Produk', 'value' => $stats['products']['total'], 'stat' => $stats['products'], 'icon' => 'box'],
                ['label' => 'Total Berita', 'value' => $stats['news']['total'], 'stat' => $stats['news'], 'icon' => 'news'],
                ['label' => 'Total Galeri', 'value' => $stats['galleries']['total'], 'stat' => $stats['galleries'], 'icon' => 'image'],
            ];
            $icons = [
                'store' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.5 1.5 0 0 1 2.122 0l8.954 8.955M4.5 9.75v9.75a1.5 1.5 0 0 0 1.5 1.5h3v-6h6v6h3a1.5 1.5 0 0 0 1.5-1.5V9.75" />',
                'box' => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5v9l-9 5.25L3 16.5v-9L12 2.25 21 7.5Zm0 0L12 12.75m0 0L3 7.5m9 5.25v9" />',
                'news' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9H21m-3 3h3m-3 3h3m-3 3h3M3.75 4.5h16.5v15H3.75v-15Z" />',
                'image' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3 3.75h18v16.5H3V3.75Z" />',
            ];
        @endphp

        @foreach ($statCards as $card)
            <div class="admin-card admin-stat-card">
                <div class="admin-stat-card__top">
                    <span class="admin-stat-card__label">{{ $card['label'] }}</span>
                    <span class="admin-stat-card__icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">{!! $icons[$card['icon']] !!}</svg>
                    </span>
                </div>
                <div class="admin-stat-card__value">{{ $card['value'] }}</div>
                <div class="admin-stat-card__trend admin-stat-card__trend--{{ $card['stat']['trend'] }}">
                    @if ($card['stat']['trend'] === 'up')
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" /></svg>
                    @else
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" /></svg>
                    @endif
                    {{ $card['stat']['percentage'] }}% dari bulan lalu
                </div>
            </div>
        @endforeach
    </div>

    {{-- ===== CHART: PRODUK BULANAN & KATEGORI ===== --}}
    <div class="admin-dashboard-grid admin-dashboard-grid--2-1">
        <div class="admin-card">
            <h3 class="admin-card__title">Unggahan Produk Bulanan</h3>
            <p class="admin-card__subtitle">Jumlah produk baru per bulan — {{ now()->year }}</p>
            <canvas id="productChart" height="90"></canvas>
        </div>

        <div class="admin-card">
            <h3 class="admin-card__title">Distribusi Kategori Produk</h3>
            <div class="admin-donut-wrap">
                <canvas id="categoryChart"></canvas>
            </div>
            <ul class="admin-legend">
                @php
                    $legendColors = ['#0f766e', '#2dd4bf', '#22c55e', '#f97316', '#d1d5db', '#a855f7'];
                    $totalCategorized = $categoryDistribution->sum('total');
                @endphp
                @foreach ($categoryDistribution as $index => $cat)
                    <li class="admin-legend__item">
                        <span class="admin-legend__dot" style="background:{{ $legendColors[$index % count($legendColors)] }}"></span>
                        <span class="admin-legend__label">{{ $cat['name'] }}</span>
                        <span class="admin-legend__value">{{ $totalCategorized > 0 ? round(($cat['total'] / $totalCategorized) * 100) : 0 }}%</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- ===== CHART: BERITA BULANAN ===== --}}
    <div class="admin-card">
        <h3 class="admin-card__title">Publikasi Berita Bulanan</h3>
        <p class="admin-card__subtitle">Jumlah berita terbit per bulan — {{ now()->year }}</p>
        <canvas id="newsChart" height="70"></canvas>
    </div>

    {{-- ===== TERBARU: PRODUK, BERITA, PENJUAL ===== --}}
    <div class="admin-dashboard-grid admin-dashboard-grid--3">
        <div class="admin-card">
            <h3 class="admin-card__title">Produk Terbaru</h3>
            <div class="admin-list">
                @forelse ($recentProducts as $product)
                    <div class="admin-list__item">
                        <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="admin-list__thumb">
                        <div class="admin-list__body">
                            <span class="admin-list__title">{{ $product->name }}</span>
                            <span class="admin-list__meta">{{ $product->sellerProfile->business_name }} • Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @empty
                    <p class="admin-list__empty">Belum ada produk.</p>
                @endforelse
            </div>
        </div>

        <div class="admin-card">
            <h3 class="admin-card__title">Berita Terbaru</h3>
            <div class="admin-list">
                @forelse ($recentNews as $news)
                    <div class="admin-list__item">
                        <img src="{{ $news->thumbnail ? asset('storage/' . $news->thumbnail) : asset('images/placeholder-news.png') }}" alt="{{ $news->title }}" class="admin-list__thumb">
                        <div class="admin-list__body">
                            <span class="admin-list__title">{{ Str::limit($news->title, 40) }}</span>
                            <span class="admin-list__meta">{{ $news->category->name }} • {{ $news->status ? 'Terbit' : 'Draft' }}</span>
                        </div>
                    </div>
                @empty
                    <p class="admin-list__empty">Belum ada berita.</p>
                @endforelse
            </div>
        </div>

        <div class="admin-card">
            <h3 class="admin-card__title">Penjual Terbaru</h3>
            <div class="admin-list">
                @forelse ($recentSellers as $seller)
                    <div class="admin-list__item">
                        <img src="{{ $seller->logo ? asset('storage/' . $seller->logo) : asset('images/placeholder-logo.png') }}" alt="{{ $seller->business_name }}" class="admin-list__thumb admin-list__thumb--round">
                        <div class="admin-list__body">
                            <span class="admin-list__title">{{ $seller->business_name }}</span>
                            <span class="admin-list__meta">{{ $seller->user->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                        </div>
                    </div>
                @empty
                    <p class="admin-list__empty">Belum ada seller.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ===== AKTIVITAS TERKINI & TINDAKAN CEPAT ===== --}}
    <div class="admin-dashboard-grid admin-dashboard-grid--2">
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

        <div class="admin-card">
            <h3 class="admin-card__title">Tindakan Cepat</h3>
            <div class="admin-quick-actions">
                <a href="{{ route('admin.news.create') }}" class="admin-quick-action">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    Tulis Berita
                </a>
                <a href="{{ route('admin.products.create') }}" class="admin-quick-action">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    Tambah Produk
                </a>
                <a href="{{ route('admin.galleries.index') }}" class="admin-quick-action">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    Tambah Galeri
                </a>
                <a href="{{ route('admin.sellers.create') }}" class="admin-quick-action">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    Tambah Seller
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const productLabels = @json($productChartLabels);
            const productData = @json($productChartData);

            new Chart(document.getElementById('productChart'), {
                type: 'line',
                data: {
                    labels: productLabels,
                    datasets: [{
                        data: productData,
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

            const categoryLabels = @json($categoryDistribution->pluck('name'));
            const categoryData = @json($categoryDistribution->pluck('total'));

            new Chart(document.getElementById('categoryChart'), {
                type: 'doughnut',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        data: categoryData,
                        backgroundColor: ['#0f766e', '#2dd4bf', '#22c55e', '#f97316', '#d1d5db', '#a855f7'],
                        borderWidth: 0,
                    }],
                },
                options: { cutout: '72%', plugins: { legend: { display: false } } },
            });

            const newsData = @json($newsChartData);

            new Chart(document.getElementById('newsChart'), {
                type: 'bar',
                data: {
                    labels: productLabels,
                    datasets: [{ data: newsData, backgroundColor: '#0f766e', borderRadius: 6, maxBarThickness: 28 }],
                },
                options: {
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, grid: { color: '#f3f4f6' } }, x: { grid: { display: false } } },
                },
            });
        </script>
    @endpush
@endsection
