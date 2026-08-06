<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title', 'Dashboard') — Portal UMKM Dadapan Village</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    @stack('styles')
</head>
<body class="admin-body">

    <div class="admin-layout">
        @include('seller.partials.sidebar')

        <div class="admin-layout__main">
            @include('seller.partials.topbar')

            <main class="admin-content">
                @if (session('success'))
                    <div class="admin-alert admin-alert--success">{{ session('success') }}</div>
                @endif
                @if (session('warning'))
                    <div class="admin-alert admin-alert--warning">{{ session('warning') }}</div>
                @endif
                @if (session('error'))
                    <div class="admin-alert admin-alert--danger">{{ session('error') }}</div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="{{ asset('js/admin/sidebar.js') }}" defer></script>
    <script src="{{ asset('js/admin/modal.js') }}" defer></script>
    <script src="{{ asset('js/admin/image-preview.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
