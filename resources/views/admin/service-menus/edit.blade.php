<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">
        <h3>Edit Menu for {{ $service->name_en }}</h3>
        <a href="{{ route('admin.services.menus.index', $service) }}" class="btn btn-outline-secondary btn-sm mb-3">Back</a>

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
            <div class="card-body">
                <form action="{{ route('admin.services.menus.update', [$service, $menu]) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @include('admin.service-menus._form', ['submitLabel' => 'Save Changes'])
                </form>
            </div>
        </div>
    </div>
</body>
</html>
