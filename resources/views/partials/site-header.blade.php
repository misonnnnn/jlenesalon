@php
    $isHomeHeader = $isHomeHeader ?? false;
    $locale = session('site_locale', 'ja');
    $isJa = $locale === 'ja';
@endphp

<nav class="main-nav top-0 start-0 w-100 {{ $isHomeHeader ? 'position-absolute pt-4' : 'position-relative bg-dark pt-4' }}">
    <a href="{{ route('home') }}" class="text-decoration-none">
        <h1 class="text-white text-center title_font mb-0">Jlene Salon</h1>
    </a>
    <hr class="text-light-hr mt-3">
    <div class="container d-flex justify-content-between align-items-center  ">
        <button class="hamburger_btn d-block d-md-none ms-auto mb-3" type="button" aria-label="Open menu">
            <i class="fa-solid fa-bars-staggered fs-2"></i>
        </button>
        <div class="sidebar_menu_background d-block d-md-none"></div>
        <ul class="list-unstyled d-flex justify-content-center align-items-center w-100 mobile_menu_active">
            <h1 class="text-white text-center title_font d-none">Jlene Salon<hr class="p-0 m-0 w-50 mx-auto" style="height: 3px !important; color: #ffffff !important;"></h1>
            <li class="nav-item"><a class="nav-link text-white" href="{{ route('home') }}"><p class="text-white p-0 m-0">ホーム</p><p class="p-0 m-0 fs-6 text-light-muted text-center text-uppercase">HOME</p></a><hr class="text-light-hr p-0 m-0 d-block d-md-none mx-auto"></li>
            <li class="nav-item desktop_service_dropdown">
                <a class="nav-link text-white" href="javascript:void(0)" role="button" aria-haspopup="true"><p class="text-white p-0 m-0">サービス・料金</p><p class="p-0 m-0 fs-6 text-light-muted text-center text-uppercase">SERVICE & PRICE</p></a>
                <ul class="desktop_service_dropdown_menu">
                    @foreach ($services as $service)
                        <li><a href="{{ route('services.show', $service) }}">{{ $isJa ? $service->name_ja : $service->name_en }}</a></li>
                    @endforeach
                </ul>
                <div class="d-block d-md-none px-3 pb-2">
                    @foreach ($services as $service)
                        <a href="{{ route('services.show', $service) }}" class="d-block text-white text-decoration-none small py-1">{{ $isJa ? $service->name_ja : $service->name_en }}</a>
                    @endforeach
                </div>
                <hr class="text-light-hr p-0 m-0 d-block d-md-none mx-auto">
            </li>
            <li class="nav-item"><a class="nav-link text-white" href="{{ route('bookings.create') }}"><p class="text-white p-0 m-0">予約する</p><p class="p-0 m-0 fs-6 text-light-muted text-center text-uppercase">BOOK</p></a><hr class="text-light-hr p-0 m-0 d-block d-md-none mx-auto"></li>
            <li class="nav-item"><a class="nav-link text-white" href="#"><p class="text-white p-0 m-0">アクセス</p><p class="p-0 m-0 fs-6 text-light-muted text-center text-uppercase">ACCESS</p></a><hr class="text-light-hr p-0 m-0 d-block d-md-none mx-auto"></li>
            <li class="nav-item"><a class="nav-link text-white" href="#"><p class="text-white p-0 m-0">スタッフ</p><p class="p-0 m-0 fs-6 text-light-muted text-center text-uppercase">STAFF</p></a><hr class="text-light-hr p-0 m-0 d-block d-md-none mx-auto"></li>
            <li class="nav-item language_switch_item px-4 py-2 ms-1">
                <a class="nav-link  p-0 {{$locale === 'ja' ? 'fw-bold text-white' : 'text-muted'}}" href="{{ route('language.switch', ['locale' => 'ja']) }}">JA</a>
                <span class="text-light-muted px-1">|</span>
                <a class="nav-link  p-0 {{$locale === 'en' ? 'fw-bold text-white' : 'text-muted'}}" href="{{ route('language.switch', ['locale' => 'en']) }}">EN</a>

            </li>
            <!-- <li class="nav-item"><a class="nav-link text-white" href="{{ route('admin.login') }}"><p class="text-white p-0 m-0">管理者ログイン</p><p class="p-0 m-0 fs-6 text-light-muted text-center text-uppercase">ADMIN LOGIN</p></a></li> -->
        </ul>
    </div>
</nav>
