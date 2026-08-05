<aside id="admin-sidebar" class="admin-sidebar">

    <div class="admin-sidebar__header">
        <a href="{{ route('admin.dashboard') }}" class="admin-sidebar__brand">
            <span class="admin-sidebar__logo">D</span>
            <span class="admin-sidebar__brand-text">
                <span class="admin-sidebar__brand-title">Desa Dadapan</span>
                <span class="admin-sidebar__brand-subtitle">Portal Administrasi</span>
            </span>
        </a>
        {{-- <button type="button" id="sidebar-collapse-toggle" class="admin-sidebar__toggle" aria-label="Ciutkan sidebar">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" /></svg>
        </button> --}}
    </div>

    <nav class="admin-sidebar__nav">

        <a href="{{ route('admin.dashboard') }}"
            class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'admin-nav-link--active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
            </svg>
            <span>Dashboard</span>
        </a>

        <p class="admin-nav-section-label">Manajemen Konten</p>

        <div class="admin-nav-group">
            <button type="button" class="admin-nav-link admin-nav-link--parent" data-submenu-toggle="berita">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9H21m-3 3h3m-3 3h3m-3 3h3M3.75 4.5h16.5v15H3.75v-15Z" />
                </svg>
                <span>Berita</span>
                <svg class="admin-nav-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </button>
            <div id="submenu-berita" class="admin-nav-submenu">
                <a href="{{ route('admin.news.index') }}" class="admin-nav-sublink">Semua Berita</a>
                <a href="{{ route('admin.news-categories.index') }}" class="admin-nav-sublink">Kategori Berita</a>
                {{-- <a href="#" class="admin-nav-sublink">Tambah Berita</a> --}}
            </div>
        </div>

        <a href="{{ route('admin.galleries.index') }}" class="admin-nav-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 15.75l5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3 3.75h18v16.5H3V3.75Z" />
            </svg>
            <span>Galeri</span>
        </a>

        <p class="admin-nav-section-label">Marketplace</p>

        <div class="admin-nav-group">
            <button type="button" class="admin-nav-link admin-nav-link--parent" data-submenu-toggle="produk">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 7.5v9l-9 5.25L3 16.5v-9L12 2.25 21 7.5Zm0 0L12 12.75m0 0L3 7.5m9 5.25v9" />
                </svg>
                <span>Produk</span>
                <svg class="admin-nav-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </button>
            <div id="submenu-produk" class="admin-nav-submenu">
                <a href="{{ route('admin.products.index') }}" class="admin-nav-sublink">Semua Produk</a>
                <a href="{{ route('admin.product-categories.index') }}" class="admin-nav-sublink">Kategori Produk</a>
            </div>
        </div>

        <a href="{{ route('admin.sellers.index') }}" class="admin-nav-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 12l8.954-8.955a1.5 1.5 0 0 1 2.122 0l8.954 8.955M4.5 9.75v9.75a1.5 1.5 0 0 0 1.5 1.5h3v-6h6v6h3a1.5 1.5 0 0 0 1.5-1.5V9.75" />
            </svg>
            <span>Penjual / UMKM</span>
        </a>

        <p class="admin-nav-section-label">Sistem</p>

        <a href="{{ route('admin.users.index') }}" class="admin-nav-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
            </svg>
            <span>Pengguna</span>
        </a>
        <a href="#" class="admin-nav-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 0 1 0 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 0 1 0-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
            <span>Pengaturan</span>
        </a>

    </nav>

    <div class="admin-sidebar__footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="admin-nav-link admin-nav-link--danger">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                </svg>
                <span>Keluar</span>
            </button>
        </form>
    </div>

</aside>

<div id="sidebar-overlay" class="admin-sidebar-overlay"></div>
