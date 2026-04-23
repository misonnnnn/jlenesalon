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
        <div class="card shadow-sm">
            <div class="card-body">
                <h4>Welcome, {{ auth()->user()->name }}</h4>
                <p class="mb-0 text-muted">This is the initial dashboard page for admin-only area.</p>
            </div>
        </div>
    </div>
</body>
</html>
