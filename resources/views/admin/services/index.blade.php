<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Services</h3>
            <div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Dashboard</a>
                <a href="{{ route('admin.services.create') }}" class="btn btn-dark">Add Service</a>
            </div>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Icon</th>
                            <th>Name</th>
                            <th>Active</th>
                            <th>Sort</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($services as $service)
                            <tr>
                                <td>{{ $service->id }}</td>
                                <td>@if ($service->icon_image)<img src="{{ asset($service->icon_image) }}" style="width:40px;height:40px;object-fit:cover;" alt="icon">@endif</td>
                                <td>
                                    <strong>{{ $service->name_en }}</strong><br>
                                    <small class="text-muted">{{ $service->name_ja }}</small>
                                </td>
                                <td>{{ $service->is_active ? 'Yes' : 'No' }}</td>
                                <td>{{ $service->sort_order }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.services.menus.index', $service) }}" class="btn btn-sm btn-outline-primary">Menus</a>
                                    <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-dark">Edit</a>
                                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this service?')" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-4">No services yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
