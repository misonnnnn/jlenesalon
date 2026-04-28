<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <title>Jlene Salon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=1.0.3">
</head>
<body>
    @php
        $locale = session('site_locale', 'ja');
        $isJa = $locale === 'ja';
        $firstService = $services->first();
    @endphp
    @include('partials.site-header', ['services' => $services, 'isHomeHeader' => true])

    <div class="vh-100 w-100 position-fixed" id="introScene" style="transform-origin: center top; will-change: transform;">
        <div class=" section vh-100 object-fit-overflow-hidden" style="background-color: #201c1c;">
            <img src="{{ asset('bg1.png') }}" alt="" class="w-100 h-100 position-absolute top-0 start-0 first_section_image" style="">
            <div class="first_section_image_gradient"></div>
            <div class="main-content position-absolute top-50 mt-5  " style="z-index: 10;">
                <!-- <p class="text-white text-center fs-2">{!! $pageWelcomeMessage[$locale] !!}</p> -->
                <!-- <p class="text-white text-center fs-6">{{ $pageDescription[$locale] }}</p> -->
                <p class="text-white fs-2">{!! $pageWelcomeMessage[$locale] !!}</p>
                <h1 class="text-white fs-1 home_title"> Where Beauty Meets Relaxation <i class="fa-solid fa-spa"></i></h1>
                <hr class="text-light-hr">
                <div class="d-flex  align-items-center justify-content-center justify-content-md-start gap-1 gap-md-3">
                    <a href="{{ route('bookings.create') }}" class="btn rounded-pill border-white border-2 text-white px-4 py-2 text-decoration-none d-inline-flex align-items-center">{{ $pageBookNowButtonText[$locale] }} <i class="fa-regular fa-hand-point-up ms-2"></i></a>
                    <button class="btn rounded-pill border-white border-2 text-white px-4 py-2" id="scrollToServicesBtn">{{ $pageSeeServicesButtonText[$locale] }}</button>
                </div>
            </div>
        </div>

        
    </div>


    <div class=" section vh-100 w-100  bg-light justify-content-center position-relative" id="whatWeDoSection" style="top:100vh;">
        <div class=" text-white stats_section">
            <div class="container">
                <div class="row text-center py-5 stats_row">
                    <div class="col-3">
                        <h5><span class="stats_row_number">900+</span><br> Satisfied Clients</h5>
                    </div>
                    <div class="col-3">
                        <h5><span class="stats_row_number">10+</span><br> Years of Experience</h5>
                    </div>
                    <div class="col-3">
                        <h5><span class="stats_row_number">1,500+</span><br>Treatments Completed</h5>
                    </div>
                    <div class="col-3">
                        <h5><span class="stats_row_number">4.9★</span><br> Professional Rating</h5>
                    </div>
                </div>
            </div>
            <hr>
        </div>
        <div class="d-flex align-items-center justify-content-center">
            <div class="container ">
                <div class="w-100">
                    <p class="fs-6 text-center m-0" style="color: #b49d59 !important;">SERVICES</p>
                    <h2 class="fs-1 text-center mb-5"><i class="fa-solid fa-spa" style="color: #b49d59 !important;"></i> What We Do</h2>
                    <hr class="text-light-hr w-25 text-center mx-auto">
                </div>
                <div class="w-100 w-md-50 mx-auto d-none">
                    <div class="row service_tabs">
                        @forelse ($services as $index => $service)
                            <div class="col-6 col-sm-6 col-md-4 col-lg-2 mx-auto">
                                <div
                                    class="service_tab_item {{ $index === 0 ? 'active' : '' }}"
                                    data-service="{{ $service->slug }}"
                                    data-title="{{ $isJa ? $service->name_ja : $service->name_en }}"
                                    data-sub-title="{{ $isJa ? $service->name_en : $service->name_ja }}"
                                    data-description="{{ $isJa ? ($service->excerpt_ja ?? $service->excerpt) : ($service->excerpt_en ?? $service->excerpt) }}"
                                    data-image="{{ $service->excerpt_image ? asset($service->excerpt_image) : asset('bg1.png') }}"
                                    data-url="{{ route('services.show', $service) }}"
                                >
                                    <div class="what_we_do_icon_outer position-relative start-50 translate-middle  mt-5">
                                        <img src="{{ $service->icon_image ? asset($service->icon_image) : asset('service/facial.png') }}" alt="{{ $service->name_en }}" class="w-100">
                                    </div>
                                    <p class="text-muted fs-6 text-center m-0 what_we_do_icon_text" style="margin-top: -20px !important; ">{{ strtoupper($isJa ? $service->name_ja : $service->name_en) }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No services added yet.</p>
                        @endforelse
                        <div class="service_active_indicator"></div>
                    </div>
                </div>
                <div class="service_stack_slider_wrap mx-auto mt-3">
                    <button type="button" class="service_stack_nav service_stack_prev" aria-label="Previous service">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <div class="service_stack_slider">
                        @foreach ($services as $service)
                            <div
                                class="service_stack_item"
                                data-service="{{ $service->slug }}"
                            >
                                <img
                                    src="{{ $service->excerpt_image ? asset($service->excerpt_image) : asset('bg1.png') }}"
                                    alt="{{ $isJa ? $service->name_ja : $service->name_en }}"
                                    class="service_stack_image"
                                >
                                <div class="service_stack_item_overlay">
                                    <div class="service_stack_content">
                                        <p class="service_stack_subtitle mb-1">{{ $isJa ? $service->name_en : $service->name_ja }}</p>
                                        <h4 class="service_stack_title mb-1">{{ strtoupper($isJa ? $service->name_ja : $service->name_en) }}</h4>
                                        <p class="service_stack_description mb-2">{{ $isJa ? ($service->excerpt_ja ?? $service->excerpt) : ($service->excerpt_en ?? $service->excerpt) }}</p>
                                        <a href="{{ route('services.show', $service) }}" class="btn service_stack_read_more">Read More</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="service_stack_nav service_stack_next" aria-label="Next service">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="container">
            <p class="text-center fs-6 text-muted "><i>Experience personalized treatments designed to relax your mind and enhance your natural beauty. From the moment you arrive, our team is here to give you a calm, luxurious salon experience with results you can feel and see.</i></p>
        </div>
        
    </div>

    <footer class="bg-dark position-relative" style="top: 100vh !important;">
        <div class="container-fluid p-3 py-5  text-white">
            <div class="row w-100">
                <div class="col-6 col-md-3">
                    <h3 class="title_font py-4">Jlene Salon</h3>
                    <p>最新のニュースやプロモーション情報を見逃さないよう、ぜひ当社のソーシャルメディアをフォローしてください。</p>
                </div>
                <div class="col-6 col-md-3"><h3>Follow Us</h3><p>最新のニュースやプロモーション情報を見逃さないよう、ぜひ当社のソーシャルメディアをフォローしてください。</p><div class="d-flex gap-3"><i class="fa-brands fa-facebook"></i><i class="fa-brands fa-instagram"></i><i class="fa-brands fa-twitter"></i><i class="fa-brands fa-youtube"></i></div></div>
                <div class="col-6 col-md-3">
                    <h3>Contact Us</h3>
                    <p>090-1234-5678</p>
                    <p>info@jlenesalon.com</p>
                    <p>1234, Main Street, Anytown, USA</p>
                </div>
                <div class="col-6 col-md-3">
                    <!-- google map -->
                    <div class="map-container">
                        <iframe class="w-100" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3242.1244197235083!2d139.7248306!3d35.6493061!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188b0046d3b615%3A0xa0461165d1406bc4!2zSmxlbmUgc2Fsb24gSGlyb28g44K444Kn44Kk44Oq44Oz44K144Ot44Oz5bqD5bC-ICjjgrfjgqfjgqLjgrXjg63jg7Mp!5e0!3m2!1sja!2sjp!4v1749805729785!5m2!1sja!2sjp" 
                            width="300" height="160" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/lenis@1.3.23/dist/lenis.min.js"></script>
    <script>
        $(function () {
            var lenis = null;
            if (typeof Lenis !== "undefined") {
                lenis = new Lenis({
                    duration: 1.1,
                    smoothWheel: true,
                    wheelMultiplier: 1
                });

                function raf(time) {
                    lenis.raf(time);
                    requestAnimationFrame(raf);
                }
                requestAnimationFrame(raf);
            }

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
            var $scrollToServicesBtn = $("#scrollToServicesBtn");
            var $whatWeDoSection = $("#whatWeDoSection");
            var $introScene = $("#introScene");
            var $serviceStackWrap = $(".service_stack_slider_wrap");
            var $serviceStackItems = $(".service_stack_item");
            var $serviceStackPrev = $(".service_stack_prev");
            var $serviceStackNext = $(".service_stack_next");
            var autoSlideTimer = null;
            var autoSlideDelay = 2000;
            var isSliderHovered = false;

            function moveServiceIndicator($activeTab) {
                var tabLeft = $activeTab.position().left + (($activeTab.outerWidth() - $activeTab.find(".what_we_do_icon_outer").outerWidth()) / 2);
                var iconWidth = $activeTab.find(".what_we_do_icon_outer").outerWidth();
                $serviceIndicator.css({ left: tabLeft + "px", width: iconWidth + "px" });
            }

            function updateStackSlider(serviceKey) {
                if (!$serviceStackItems.length) return;
                var activeIndex = $serviceStackItems.index($serviceStackItems.filter('[data-service="' + serviceKey + '"]'));
                if (activeIndex < 0) activeIndex = 0;
                var total = $serviceStackItems.length;

                $serviceStackItems.each(function (index) {
                    var offset = index - activeIndex;
                    if (offset > total / 2) offset -= total;
                    if (offset < -total / 2) offset += total;
                    $(this).attr("data-offset", offset);
                });
            }

            function getAdjacentService(currentService, step) {
                if (!$serviceStackItems.length) return currentService;
                var $current = $serviceStackItems.filter('[data-service="' + currentService + '"]');
                var currentIndex = $serviceStackItems.index($current);
                if (currentIndex < 0) currentIndex = 0;
                var total = $serviceStackItems.length;
                var nextIndex = (currentIndex + step + total) % total;
                return $serviceStackItems.eq(nextIndex).data("service");
            }

            function setActiveService(serviceKey) {
                var $activeTab = $serviceTabs.filter('[data-service="' + serviceKey + '"]');
                if (!$activeTab.length) return;
                $serviceTabs.removeClass("active");
                $activeTab.addClass("active");
                moveServiceIndicator($activeTab);
                updateStackSlider(serviceKey);
            }

            function goToNextService() {
                var currentService = $serviceTabs.filter(".active").data("service");
                setActiveService(getAdjacentService(currentService, 1));
            }

            function stopAutoSlide() {
                if (autoSlideTimer) {
                    clearInterval(autoSlideTimer);
                    autoSlideTimer = null;
                }
            }

            function startAutoSlide() {
                stopAutoSlide();
                if ($serviceStackItems.length <= 1) return;
                autoSlideTimer = setInterval(function () {
                    if (isSliderHovered) return;
                    goToNextService();
                }, autoSlideDelay);
            }

            function clamp(value, min, max) {
                return Math.min(Math.max(value, min), max);
            }

            function animateStatsCounters() {
                var $statsNumbers = $(".stats_row_number");
                if (!$statsNumbers.length) return;

                var duration = 4000;
                var startTs = null;

                var items = $statsNumbers.map(function () {
                    var $el = $(this);
                    var raw = String($el.text()).trim();
                    var match = raw.match(/[\d,.]+/);
                    if (!match) {
                        return {
                            $el: $el,
                            raw: raw,
                            target: 0,
                            prefix: "",
                            suffix: "",
                            decimals: 0
                        };
                    }

                    var numText = match[0];
                    var target = parseFloat(numText.replace(/,/g, ""));
                    var startIdx = match.index || 0;
                    var endIdx = startIdx + numText.length;
                    var decimals = (numText.split(".")[1] || "").length;

                    return {
                        $el: $el,
                        raw: raw,
                        target: Number.isFinite(target) ? target : 0,
                        prefix: raw.slice(0, startIdx),
                        suffix: raw.slice(endIdx),
                        decimals: decimals
                    };
                }).get();

                function step(ts) {
                    if (!startTs) startTs = ts;
                    var linearProgress = Math.min((ts - startTs) / duration, 1);
                    // Ease-out: fast start, slower near the end.
                    var progress = 1 - Math.pow(1 - linearProgress, 3);

                    items.forEach(function (item) {
                        if (!item.target) {
                            item.$el.text(item.raw);
                            return;
                        }

                        var value = item.target * progress;
                        var rendered;
                        if (item.decimals > 0) {
                            rendered = value.toFixed(item.decimals);
                        } else {
                            rendered = Math.floor(value).toLocaleString();
                        }

                        item.$el.text(item.prefix + rendered + item.suffix);
                    });

                    if (linearProgress < 1) {
                        requestAnimationFrame(step);
                    } else {
                        items.forEach(function (item) {
                            item.$el.text(item.raw);
                        });
                    }
                }

                requestAnimationFrame(step);
            }

            function updateIntroShrink() {
                if (!$introScene.length) return;
                var scrollTop = window.scrollY || window.pageYOffset || 0;
                var progress = clamp(scrollTop / window.innerHeight, 0, 1);
                var scale = 1 - (0.12 * progress);
                $introScene.css("transform", "scale(" + scale.toFixed(3) + ")");
            }

            $serviceTabs.on("click", function () { setActiveService($(this).data("service")); });
            $serviceStackItems.on("click", function () { setActiveService($(this).data("service")); });
            $serviceStackPrev.on("click", function () {
                var currentService = $serviceTabs.filter(".active").data("service");
                setActiveService(getAdjacentService(currentService, -1));
            });
            $serviceStackNext.on("click", function () {
                goToNextService();
            });
            $serviceStackWrap.on("mouseenter", function () { isSliderHovered = true; });
            $serviceStackWrap.on("mouseleave", function () { isSliderHovered = false; });
            $scrollToServicesBtn.on("click", function () {
                if (!$whatWeDoSection.length) return;

                if (lenis) {
                    lenis.scrollTo($whatWeDoSection[0], { offset: -20, duration: 1 });
                } else {
                    $("html, body").animate({ scrollTop: $whatWeDoSection.offset().top }, 300);
                }
            });

            if ($serviceTabs.length) {
                setActiveService($serviceTabs.first().data("service"));
            }
            startAutoSlide();
            updateIntroShrink();

            var statsAnimated = false;
            var statsSection = document.querySelector(".stats_section");
            if (statsSection && "IntersectionObserver" in window) {
                var statsObserver = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting && !statsAnimated) {
                            statsAnimated = true;
                            animateStatsCounters();
                            statsObserver.disconnect();
                        }
                    });
                }, { threshold: 0.01 });
                statsObserver.observe(statsSection);
            } else {
                animateStatsCounters();
            }

            if (lenis && typeof lenis.on === "function") {
                lenis.on("scroll", function () {
                    updateIntroShrink();
                });
            } else {
                $(window).on("scroll", function () {
                    updateIntroShrink();
                });
            }

            $(window).on("resize", function () {
                var $currentActive = $serviceTabs.filter(".active");
                if ($currentActive.length) { moveServiceIndicator($currentActive); }
                updateIntroShrink();
            });
        });
    </script>
</body>
</html>
