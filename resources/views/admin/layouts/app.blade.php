<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row min-vh-100">
            <aside class="col-12 col-md-3 col-lg-2 bg-dark text-white p-3">
                <h5 class="mb-4">Jlene Admin</h5>

                <nav class="nav flex-column gap-2">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link px-3 py-2 rounded {{ request()->routeIs('admin.dashboard') ? 'bg-white text-dark' : 'text-white-50' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.bookings') }}"
                        class="nav-link px-3 py-2 rounded {{ request()->routeIs('admin.bookings') ? 'bg-white text-dark' : 'text-white-50' }}">
                        Bookings
                    </a>
                    <a href="{{ route('admin.services.index') }}"
                        class="nav-link px-3 py-2 rounded {{ request()->routeIs('admin.services.*') ? 'bg-white text-dark' : 'text-white-50' }}">
                        CMS Services
                    </a>
                </nav>

                <hr class="border-secondary my-4">

                <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm w-100 mb-2">View Website</a>
                <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
                    @csrf
                    <button class="btn btn-danger btn-sm w-100" type="submit">Logout</button>
                </form>
            </aside>

            <main class="col-12 col-md-9 col-lg-10 p-4">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                @yield('admin-content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
