<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jlene Salon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @php
        $locale = session('site_locale', 'ja');
        $isJa = $locale === 'ja';
        $firstService = $services->first();
    @endphp
    @include('partials.site-header', ['services' => $services, 'isHomeHeader' => true])

    <div class="first_section section vh-100 object-fit-overflow-hidden" style="background-color: #201c1c;">
        <img src="{{ asset('bg1.png') }}" alt="" class="w-100 h-100 position-absolute top-0 start-0" style="object-fit: cover; object-position: center; opacity: 0.3;">
        <div class="main-content position-absolute top-50 mt-5 w-75 start-50 translate-middle" style="z-index: 10;">
            <p class="text-white text-center fs-2"><span class="title_font fs-4 ms-2">Jlene Salon </span>へようこそ</p>
            <p class="text-white text-center fs-6">Jlene Salonでは、美しさはケアから始まると考えています。私たちの専門チームは、リラックスしながら心身をリフレッシュし、最高のあなたを引き出すために設計されたプロフェッショナルなサロンおよびスキンケアサービスをご提供しています。</p>
            <hr class="text-light-hr">
            <div class="d-flex justify-content-center align-items-center gap-3">
                <button class="btn rounded-pill border-white border-2 text-white px-4 py-2" style="background-color: #b49d59;">予約する</button>
                <button class="btn rounded-pill border-white border-2 text-white px-4 py-2" id="scrollToServicesBtn">サービスを見る</button>
            </div>
        </div>
    </div>

    <div class="first_section section vh-100 w-100" id="whatWeDoSection">
        <div class="container py-5">
            <div class="w-100"><p class="fs-6 text-center m-0" style="color: #b49d59 !important;">SERVICES</p><h2 class="fs-1 text-center">What We Do</h2><hr class="text-light-hr w-25 text-center mx-auto"></div>
            <div class="w-100 w-md-50 mx-auto">
                <div class="d-flex justify-content-between align-items-center service_tabs">
                    @forelse ($services as $index => $service)
                        <div
                            class="service_tab_item {{ $index === 0 ? 'active' : '' }}"
                            data-service="{{ $service->slug }}"
                            data-title="{{ $isJa ? $service->name_ja : $service->name_en }}"
                            data-sub-title="{{ $isJa ? $service->name_en : $service->name_ja }}"
                            data-description="{{ $isJa ? ($service->excerpt_ja ?? $service->excerpt) : ($service->excerpt_en ?? $service->excerpt) }}"
                            data-image="{{ $service->excerpt_image ? asset($service->excerpt_image) : asset('bg1.png') }}"
                            data-url="{{ route('services.show', $service) }}"
                        >
                            <div class="what_we_do_icon_outer">
                                <img src="{{ $service->icon_image ? asset($service->icon_image) : asset('service/facial.png') }}" alt="{{ $service->name_en }}" class="w-100">
                            </div>
                            <p class="text-muted fs-6 text-center m-0 what_we_do_icon_text">{{ strtoupper($isJa ? $service->name_ja : $service->name_en) }}</p>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No services added yet.</p>
                    @endforelse
                    <div class="service_active_indicator"></div>
                </div>
            </div>
            <div class="w-75 mx-auto mt-5">
                <div class="row">
                    <div class="col-md-7"><div class="shadow border border-white border-3"><img src="{{ $firstService?->excerpt_image ? asset($firstService->excerpt_image) : asset('bg1.png') }}" alt="" class="w-100" id="serviceDetailImage"></div></div>
                    <div class="col-md-5">
                        <h3 id="serviceDetailTitle">{{ $firstService ? ($isJa ? $firstService->name_ja : $firstService->name_en) : 'SERVICE' }}</h3>
                        <p class="text-muted mb-2" id="serviceDetailSubTitle">{{ $firstService ? ($isJa ? $firstService->name_en : $firstService->name_ja) : '' }}</p>
                        <hr class="w-25" style="color: #b49d59 !important;">
                        <p id="serviceDetailDescription">{{ $firstService ? ($isJa ? ($firstService->excerpt_ja ?? $firstService->excerpt) : ($firstService->excerpt_en ?? $firstService->excerpt)) : 'No service content yet.' }}</p>
                        @if ($firstService)
                            <a href="{{ route('services.show', $firstService) }}" class="btn rounded-pill border-white border-2 text-white px-4 py-2 text-decoration-none" style="background-color: #b49d59;" id="serviceDetailButton">Read More</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer style="margin-top: 200px;">
        <div class="container-fluid p-3 bg-dark text-white mt-5">
            <div class="d-flex justify-content-between align-items-center w-100">
                <div class="w-50"><h3 class="title_font p-4">Jlene Salon</h3></div>
                <div class="w-50"><h3>Follow Us</h3><p>最新のニュースやプロモーション情報を見逃さないよう、ぜひ当社のソーシャルメディアをフォローしてください。</p><div class="d-flex gap-3"><i class="fa-brands fa-facebook"></i><i class="fa-brands fa-instagram"></i><i class="fa-brands fa-twitter"></i><i class="fa-brands fa-youtube"></i></div></div>
            </div>
        </div>
    </footer>

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

            var $serviceTabs = $(".service_tab_item");
            var $serviceIndicator = $(".service_active_indicator");
            var $serviceTitle = $("#serviceDetailTitle");
            var $serviceSubTitle = $("#serviceDetailSubTitle");
            var $serviceDescription = $("#serviceDetailDescription");
            var $serviceImage = $("#serviceDetailImage");
            var $serviceButton = $("#serviceDetailButton");
            var $scrollToServicesBtn = $("#scrollToServicesBtn");
            var $whatWeDoSection = $("#whatWeDoSection");

            function moveServiceIndicator($activeTab) {
                var tabLeft = $activeTab.position().left + (($activeTab.outerWidth() - $activeTab.find(".what_we_do_icon_outer").outerWidth()) / 2);
                var iconWidth = $activeTab.find(".what_we_do_icon_outer").outerWidth();
                $serviceIndicator.css({ left: tabLeft + "px", width: iconWidth + "px" });
            }

            function setActiveService(serviceKey) {
                var $activeTab = $serviceTabs.filter('[data-service="' + serviceKey + '"]');
                if (!$activeTab.length) return;
                $serviceTabs.removeClass("active");
                $activeTab.addClass("active");
                $serviceTitle.text($activeTab.data("title") || "");
                $serviceSubTitle.text($activeTab.data("sub-title") || "");
                $serviceDescription.text($activeTab.data("description") || "");
                $serviceImage.attr("src", $activeTab.data("image"));
                $serviceImage.attr("alt", $activeTab.data("sub-title"));
                $serviceButton.attr("href", $activeTab.data("url"));
                moveServiceIndicator($activeTab);
            }

            $serviceTabs.on("click", function () { setActiveService($(this).data("service")); });
            $scrollToServicesBtn.on("click", function () {
                if ($whatWeDoSection.length) { $("html, body").animate({ scrollTop: $whatWeDoSection.offset().top }, 300); }
            });

            if ($serviceTabs.length) {
                setActiveService($serviceTabs.first().data("service"));
            }
            $(window).on("resize", function () {
                var $currentActive = $serviceTabs.filter(".active");
                if ($currentActive.length) { moveServiceIndicator($currentActive); }
            });
        });
    </script>
</body>
</html>
