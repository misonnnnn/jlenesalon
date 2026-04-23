<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $service->name_en }} | Jlene Salon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body style="background: #f8f9fa;">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand title_font" href="{{ route('home') }}">Jlene Salon</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Services</a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @foreach ($services as $item)
                                <li><a class="dropdown-item" href="{{ route('services.show', $item) }}">{{ $item->name_en }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row g-4 align-items-center">
            <div class="col-md-6">
                <img src="{{ $service->excerpt_image ? asset($service->excerpt_image) : asset('bg1.png') }}" alt="{{ $service->name_en }}" class="img-fluid rounded shadow-sm">
            </div>
            <div class="col-md-6">
                <p class="text-uppercase text-muted mb-1">{{ $service->name_en }}</p>
                <h1 class="mb-3">{{ $service->name_ja }}</h1>
                <p class="mb-0">{{ $service->excerpt }}</p>
            </div>
        </div>

        <hr class="my-5">

        <h2 class="mb-3">Service Menus</h2>
        <div class="row g-4">
            @forelse ($service->menus as $menu)
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm">
                        @if ($menu->poster_image)
                            <img src="{{ asset($menu->poster_image) }}" class="card-img-top" alt="{{ $menu->title }}" style="max-height: 260px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5>{{ $menu->title }}</h5>
                            <p class="mb-2">{{ $menu->description }}</p>
                            <p class="mb-0 text-muted">
                                @if ($menu->duration) Duration: {{ $menu->duration }} @endif
                                @if ($menu->duration && $menu->price) | @endif
                                @if ($menu->price) Price: {{ $menu->price }} @endif
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-muted">No service menu added yet for this service.</p>
                </div>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
