<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $service->name_en }} | Jlene Salon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body style="background: #f8f9fa;">
    @include('partials.site-header', ['services' => $services, 'isHomeHeader' => false])

    <div class="container py-5">
        <div class="row g-4 align-items-center">
            <div class="col-md-6">
                <img src="{{ $service->excerpt_image ? asset($service->excerpt_image) : asset('bg1.png') }}" alt="{{ $service->name_en }}" class="img-fluid rounded shadow-sm">
            </div>
            <div class="col-md-6">
                <p class="text-uppercase text-muted mb-1">{{ $service->name_en }}</p>
                <h1 class="mb-3">{{ $service->name_ja }}</h1>
                <p class="mb-0">{{ $service->excerpt_ja ?? $service->excerpt }}</p>
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
                            <h5>{{ $menu->title_ja ?? $menu->title }}</h5>
                            <p class="mb-2">{{ $menu->description_ja ?? $menu->description }}</p>
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
    <script>
        $(function () {
            var mobileBreakpoint = 768;
            var $body = $("body");
            var $menu = $(".mobile_menu_active");
            var $overlay = $(".sidebar_menu_background");
            var $toggleBtn = $(".hamburger_btn");

            function closeSidebar() { $body.removeClass("sidebar_open"); }

            $toggleBtn.on("click", function () { $body.toggleClass("sidebar_open"); });
            $overlay.on("click", function () { closeSidebar(); });
            $menu.find("a").on("click", function () { closeSidebar(); });
            $(window).on("resize", function () { if ($(window).width() > mobileBreakpoint) { closeSidebar(); } });
        });
    </script>
</body>
</html>
