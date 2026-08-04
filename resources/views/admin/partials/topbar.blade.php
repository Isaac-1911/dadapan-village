@php
    $initials = collect(explode(' ', auth()->user()->name))
        ->map(fn($word) => strtoupper(substr($word, 0, 1)))
        ->take(2)
        ->implode('');
@endphp

<header class="admin-topbar">

    <div class="admin-topbar__left">
        {{-- <button type="button" id="mobile-sidebar-toggle" class="admin-topbar__icon-btn admin-topbar__menu-btn" aria-label="Buka menu">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" /></svg>
        </button> --}}

        <nav class="admin-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Portal Admin</a>
            <span class="admin-breadcrumb__sep">›</span>
            <span class="admin-breadcrumb__current">@yield('page-title', 'Dashboard')</span>
        </nav>
    </div>

    <div class="admin-topbar__right">
        <button type="button" class="admin-topbar__icon-btn" aria-label="Notifikasi">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" /></svg>
            <span class="admin-topbar__badge"></span>
        </button>

        <div class="admin-topbar__user">
            <span class="admin-topbar__avatar">{{ $initials }}</span>
            <div class="admin-topbar__user-info">
                <span class="admin-topbar__user-name">{{ auth()->user()->name }}</span>
                <span class="admin-topbar__user-email">{{ auth()->user()->email }}</span>
            </div>
        </div>
    </div>

</header>
