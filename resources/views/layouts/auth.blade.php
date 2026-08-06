<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title', 'Masuk') — Portal Desa Dadapan</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin-auth-body">
    <div class="admin-auth-wrap">
        <div class="admin-auth-card">
            <div class="admin-auth-brand">
                <span class="admin-sidebar__logo admin-auth-brand__logo">D</span>
                <div>
                    <span class="admin-auth-brand__title">Desa Dadapan</span>
                    <span class="admin-auth-brand__subtitle">Portal Administrasi</span>
                </div>
            </div>

            @yield('content')
        </div>

        <p class="admin-auth-footer">© {{ now()->year }} Desa Dadapan. Seluruh hak cipta dilindungi.</p>
    </div>
</body>
</html>
