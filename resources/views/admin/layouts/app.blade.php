<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --admin-bg: #f6f9fc;
            --admin-surface: #ffffff;
            --admin-border: #e6ebf1;
            --admin-text: #1f2937;
            --admin-muted: #6b7280;
            --admin-sidebar: #0f172a;
            --admin-sidebar-muted: #a3b1c9;
            --admin-accent: #635bff;
            --admin-accent-soft: #eef0ff;
        }
        body.admin-body {
            background: var(--admin-bg);
            color: var(--admin-text);
            font-family: Inter, "Segoe UI", Roboto, Arial, sans-serif;
        }
        .admin-shell {
            min-height: 100vh;
            display: flex;
        }
        .admin-sidebar {
            width: 250px;
            background: var(--admin-sidebar);
            color: #fff;
            padding: 1.5rem 1rem;
            position: sticky;
            top: 0;
            height: 100vh;
        }
        .admin-brand {
            font-weight: 700;
            letter-spacing: .2px;
            margin-bottom: 1.5rem;
        }
        .admin-sidebar .nav-link {
            color: var(--admin-sidebar-muted);
            border-radius: 10px;
            padding: .65rem .8rem;
            font-size: .9rem;
            font-weight: 500;
        }
        .admin-sidebar .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,.08);
        }
        .admin-sidebar .nav-link.active {
            color: #fff;
            background: rgba(99,91,255,.35);
        }
        .admin-sidebar .btn {
            border-radius: 10px;
            font-size: .85rem;
            font-weight: 600;
        }
        .admin-main {
            flex: 1;
            min-width: 0;
        }
        .admin-topbar {
            height: 68px;
            background: var(--admin-surface);
            border-bottom: 1px solid var(--admin-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
        }
        .admin-page {
            padding: 1.5rem;
        }
        .admin-card {
            background: var(--admin-surface);
            border: 1px solid var(--admin-border);
            border-radius: 14px;
            box-shadow: 0 1px 2px rgba(16,24,40,.04);
        }
        .admin-card-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--admin-border);
        }
        .admin-table thead th {
            border-bottom-color: var(--admin-border);
            color: var(--admin-muted);
            font-size: .75rem;
            text-transform: uppercase;
            letter-spacing: .03em;
            font-weight: 700;
        }
        .admin-table td {
            border-bottom-color: #f1f4f8;
            vertical-align: middle;
        }
        .admin-page-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
        }
        .admin-muted {
            color: var(--admin-muted);
        }
        .btn-admin-primary {
            background: var(--admin-accent);
            color: #fff;
            border-color: var(--admin-accent);
        }
        .btn-admin-primary:hover {
            background: #4f46e5;
            border-color: #4f46e5;
            color: #fff;
        }
        .badge-soft {
            background: var(--admin-accent-soft);
            color: var(--admin-accent);
            border: 1px solid #d9deff;
            font-weight: 600;
            padding: .35rem .55rem;
            border-radius: 999px;
        }
        @media (max-width: 991px) {
            .admin-shell {
                display: block;
            }
            .admin-sidebar {
                width: 100%;
                height: auto;
                position: static;
            }
        }
    </style>
</head>
<body class="admin-body">
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <div class="admin-brand">Jlene Salon Admin</div>
            <nav class="nav flex-column gap-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.bookings') }}"
                    class="nav-link {{ request()->routeIs('admin.bookings') ? 'active' : '' }}">
                    Bookings
                </a>
                <a href="{{ route('admin.services.index') }}"
                    class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                    Services
                </a>
            </nav>

            <hr class="border-secondary my-4">

            <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-light btn-sm w-100 mb-2">View Website</a>
            <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
                @csrf
                <button class="btn btn-danger btn-sm w-100" type="submit">Logout</button>
            </form>
        </aside>

        <main class="admin-main">
            <div class="admin-topbar">
                <div>
                    <strong>@yield('title', 'Admin Panel')</strong>
                </div>
                <div class="admin-muted small">
                    {{ auth()->user()->name ?? 'Admin' }}
                </div>
            </div>
            <div class="admin-page">
                @if (session('status'))
                    <div class="alert alert-success border-0 shadow-sm">{{ session('status') }}</div>
                @endif

                @yield('admin-content')
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
