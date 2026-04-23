<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Jlene Admin Dashboard</span>
            <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
                @csrf
                <button class="btn btn-outline-light btn-sm" type="submit">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container py-4">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <div class="card shadow-sm">
            <div class="card-body">
                <h4>Welcome, {{ auth()->user()->name }}</h4>
                <p class="text-muted">Manage salon CMS content from here.</p>
                <a href="{{ route('admin.services.index') }}" class="btn btn-dark">Manage Services</a>
            </div>
        </div>
    </div>
</body>
</html>
