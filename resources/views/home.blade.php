<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jlene Salon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        @font-face {
            font-family: 'SenjalaraDemoRegular';
            src: url('{{ asset('SenjalaraDemoRegular.ttf') }}') format('truetype');
        }

        body { font-family: 'trebuchet ms', sans-serif; }
        .title_font { font-family: 'SenjalaraDemoRegular'; font-size: 2rem; font-weight: bold; color: #fff; }
        .text-light-hr { color: #a1a1a1; }
        .text-light-muted { color: #ffffff94; }
        .nav-link { font-size: 1.2rem; color: #a1a1a1; transition: all 0.3s ease; }
        .nav-link:hover { color: #ffffff !important; text-shadow: 0 0 10px #ffffff; transition: all 0.3s ease; }
        .main-nav { z-index: 9; }
        .hamburger_btn { background: transparent; border: 1px solid rgba(255, 255, 255, 0.8); color: #fff; border-radius: 6px; padding: 6px 10px; line-height: 1; }
        .hamburger_btn:focus { outline: none; box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.25); }
        .what_we_do_icon_outer { height: 80px; width: 80px; }
        .service_tabs { position: relative; padding-bottom: 20px; }
        .service_tab_item { cursor: pointer; }
        .service_tab_item img { transition: transform 0.2s ease; }
        .service_tab_item.active img, .service_tab_item:hover img { transform: translateY(-4px); }
        .service_active_indicator { position: absolute; bottom: 0; left: 0; height: 3px; width: 80px; background-color: #b49d59; transition: left 0.25s ease, width 0.25s ease; }

        @media screen and (max-width: 768px) {
            .mobile_menu_active { background-color: #201c1c !important; width: 80% !important; height: 100vh !important; display: block !important; position: fixed !important; top: 0; left: 0; padding-top: 50px; border-right: 1px solid #ffffff !important; transform: translateX(-100%); transition: transform 0.35s ease-in-out; z-index: 999; }
            .mobile_menu_active p { text-align: left !important; }
            .mobile_menu_active li { width: 100%; padding: 0 1rem; }
            .what_we_do_icon_outer { height: 50px; width: 50px; }
            .service_active_indicator { width: 50px; }
            .what_we_do_icon_text { font-size: 0.8rem !important; }
            .main-nav { z-index: 99 !important; }
            .mobile_menu_active h1 { font-size: 1.5rem !important; display: block !important; }
            .sidebar_menu_background { background-color: rgba(0, 0, 0, 0.5) !important; width: 100% !important; height: 100vh !important; position: fixed !important; top: 0 !important; left: 0 !important; opacity: 0; visibility: hidden; transition: opacity 0.25s ease; z-index: 998; }
            body.sidebar_open .mobile_menu_active { transform: translateX(0); }
            body.sidebar_open .sidebar_menu_background { opacity: 1; visibility: visible; }
        }
    </style>
</head>
<body>
    <nav class="main-nav position-absolute top-0 start-0 w-100 py-5">
        <h1 class="text-white text-center title_font">Jlene Salon</h1>
        <hr class="text-light-hr mt-5">
        <div class="container d-flex justify-content-between align-items-center">
            <button class="hamburger_btn d-block d-md-none ms-auto mb-3" type="button" aria-label="Open menu">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="sidebar_menu_background d-block d-md-none"></div>
            <ul class="list-unstyled d-flex justify-content-center align-items-center w-100 mobile_menu_active">
                <h1 class="text-white text-center title_font d-none">Jlene Salon<hr class="p-0 m-0 w-50 mx-auto" style="height: 3px !important; color: #ffffff !important;"></h1>
                <li class="nav-item"><a class="nav-link text-white" href="#"><p class="text-white p-0 m-0">ホーム</p><p class="p-0 m-0 fs-6 text-light-muted text-center text-uppercase">HOME</p></a><hr class="text-light-hr p-0 m-0 d-block d-md-none mx-auto"></li>
                <li class="nav-item"><a class="nav-link text-white" href="#"><p class="text-white p-0 m-0">サービス・料金</p><p class="p-0 m-0 fs-6 text-light-muted text-center text-uppercase">SERVICE & PRICE</p></a><hr class="text-light-hr p-0 m-0 d-block d-md-none mx-auto"></li>
                <li class="nav-item"><a class="nav-link text-white" href="#"><p class="text-white p-0 m-0">アクセス</p><p class="p-0 m-0 fs-6 text-light-muted text-center text-uppercase">ACCESS</p></a><hr class="text-light-hr p-0 m-0 d-block d-md-none mx-auto"></li>
                <li class="nav-item"><a class="nav-link text-white" href="#"><p class="text-white p-0 m-0">スタッフ</p><p class="p-0 m-0 fs-6 text-light-muted text-center text-uppercase">STAFF</p></a><hr class="text-light-hr p-0 m-0 d-block d-md-none mx-auto"></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('admin.login') }}"><p class="text-white p-0 m-0">管理者ログイン</p><p class="p-0 m-0 fs-6 text-light-muted text-center text-uppercase">ADMIN LOGIN</p></a></li>
                <hr class="text-light-hr p-0 m-0 d-block d-md-none mx-auto">
            </ul>
        </div>
    </nav>

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
                    <div class="service_tab_item active" data-service="facial"><div class="what_we_do_icon_outer"><img src="{{ asset('service/facial.png') }}" alt="" class="w-100"></div><p class="text-muted fs-6 text-center m-0 what_we_do_icon_text">FACIAL</p></div>
                    <div class="service_tab_item" data-service="relaxation"><div class="what_we_do_icon_outer"><img src="{{ asset('service/relaxation.png') }}" alt="" class="w-100"></div><p class="text-muted fs-6 text-center m-0 what_we_do_icon_text">RELAXATION</p></div>
                    <div class="service_tab_item" data-service="threading"><div class="what_we_do_icon_outer"><img src="{{ asset('service/threading.png') }}" alt="" class="w-100"></div><p class="text-muted fs-6 text-center m-0 what_we_do_icon_text">THREADING</p></div>
                    <div class="service_tab_item" data-service="nails"><div class="what_we_do_icon_outer"><img src="{{ asset('service/nails.png') }}" alt="" class="w-100"></div><p class="text-muted fs-6 text-center m-0 what_we_do_icon_text">NAILS</p></div>
                    <div class="service_tab_item" data-service="hair"><div class="what_we_do_icon_outer"><img src="{{ asset('service/hair.png') }}" alt="" class="w-100"></div><p class="text-muted fs-6 text-center m-0 what_we_do_icon_text">HAIR</p></div>
                    <div class="service_active_indicator"></div>
                </div>
            </div>
            <div class="w-75 mx-auto mt-5">
                <div class="row">
                    <div class="col-md-7"><div class="shadow border border-white border-3"><img src="{{ asset('bg1.png') }}" alt="" class="w-100" id="serviceDetailImage"></div></div>
                    <div class="col-md-5">
                        <h3 id="serviceDetailTitle">FACIAL SERVICE</h3>
                        <p class="text-muted mb-2" id="serviceDetailSubTitle">FACIAL</p>
                        <hr class="w-25" style="color: #b49d59 !important;">
                        <p id="serviceDetailDescription">お肌の状態に合わせた丁寧なフェイシャルケアで、透明感のある健やかな肌へ導きます。日々の疲れをやさしく癒しながら、ハリと潤いを実感いただける人気メニューです。</p>
                        <button class="btn rounded-pill border-white border-2 text-white px-4 py-2" style="background-color: #b49d59;" id="serviceDetailButton">Read More</button>
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

            var serviceData = {
                facial: { title: "フェイシャルケア", sub_title: "FACIAL", description: "お肌の状態に合わせた丁寧なフェイシャルケアで、透明感のある健やかな肌へ導きます。日々の疲れをやさしく癒しながら、ハリと潤いを実感いただける人気メニューです。", image: "{{ asset('service/main_image/facial.png') }}" },
                relaxation: { title: "リラックスサービス", sub_title: "RELAXATION", description: "アロマオイルを使った施術でお客様を極上のリラックスへと導きます。アロマの香に包まれながら日々の疲れを解消したい方におすすめです。活力を取り戻したような感覚になります。", image: "{{ asset('service/main_image/relaxation.png') }}" },
                threading: { title: "スレッディングサービス", sub_title: "THREADING", description: "肌に優しいスレッディング技術で、産毛や不要な毛を丁寧に整えます。顔全体の印象をすっきりと見せ、メイクのノリも良くなる繊細なケアです。", image: "{{ asset('service/main_image/threading.png') }}" },
                nails: { title: "ネイルサービス", sub_title: "NAILS", description: "トレンド感のあるデザインから上品なシンプルネイルまで、ライフスタイルに合わせてご提案。指先から気分を高める美しい仕上がりをお届けします。", image: "{{ asset('service/main_image/nails.png') }}" },
                hair: { title: "ヘアサービス", sub_title: "HAIR", description: "髪質や骨格に合わせたカットとケアで、毎日扱いやすいスタイルを実現。ダメージを抑えながら、ツヤとまとまりのあるヘアへ導きます。", image: "{{ asset('service/main_image/hair.png') }}" }
            };

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
                var selectedService = serviceData[serviceKey];
                if (!selectedService) return;
                var $activeTab = $serviceTabs.filter('[data-service="' + serviceKey + '"]');
                $serviceTabs.removeClass("active");
                $activeTab.addClass("active");
                $serviceTitle.text(selectedService.title);
                $serviceSubTitle.text(selectedService.sub_title || "");
                $serviceDescription.text(selectedService.description);
                $serviceImage.attr("src", selectedService.image);
                $serviceImage.attr("alt", selectedService.sub_title);
                $serviceButton.attr("data-service", serviceKey);
                moveServiceIndicator($activeTab);
            }

            $serviceTabs.on("click", function () { setActiveService($(this).data("service")); });
            $scrollToServicesBtn.on("click", function () {
                if ($whatWeDoSection.length) { $("html, body").animate({ scrollTop: $whatWeDoSection.offset().top }, 300); }
            });

            setActiveService("facial");
            $(window).on("resize", function () {
                var $currentActive = $serviceTabs.filter(".active");
                if ($currentActive.length) { moveServiceIndicator($currentActive); }
            });
        });
    </script>
</body>
</html>
