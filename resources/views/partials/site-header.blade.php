@php
    $isHomeHeader = $isHomeHeader ?? false;
@endphp

<nav class="main-nav top-0 start-0 w-100 {{ $isHomeHeader ? 'position-absolute py-5' : 'position-relative bg-dark py-3' }}">
    <h1 class="text-white text-center title_font mb-0">Jlene Salon</h1>
    <hr class="text-light-hr mt-3">
    <div class="container d-flex justify-content-between align-items-center">
        <button class="hamburger_btn d-block d-md-none ms-auto mb-3" type="button" aria-label="Open menu">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div class="sidebar_menu_background d-block d-md-none"></div>
        <ul class="list-unstyled d-flex justify-content-center align-items-center w-100 mobile_menu_active">
            <h1 class="text-white text-center title_font d-none">Jlene Salon<hr class="p-0 m-0 w-50 mx-auto" style="height: 3px !important; color: #ffffff !important;"></h1>
            <li class="nav-item"><a class="nav-link text-white" href="{{ route('home') }}"><p class="text-white p-0 m-0">ホーム</p><p class="p-0 m-0 fs-6 text-light-muted text-center text-uppercase">HOME</p></a><hr class="text-light-hr p-0 m-0 d-block d-md-none mx-auto"></li>
            <li class="nav-item desktop_service_dropdown">
                <a class="nav-link text-white" href="{{ $isHomeHeader ? '#whatWeDoSection' : route('home') . '#whatWeDoSection' }}"><p class="text-white p-0 m-0">サービス・料金</p><p class="p-0 m-0 fs-6 text-light-muted text-center text-uppercase">SERVICE & PRICE</p></a>
                <ul class="desktop_service_dropdown_menu">
                    @foreach ($services as $service)
                        <li><a href="{{ route('services.show', $service) }}">{{ $service->name_en }}</a></li>
                    @endforeach
                </ul>
                <div class="d-block d-md-none px-3 pb-2">
                    @foreach ($services as $service)
                        <a href="{{ route('services.show', $service) }}" class="d-block text-white text-decoration-none small py-1">{{ $service->name_en }}</a>
                    @endforeach
                </div>
                <hr class="text-light-hr p-0 m-0 d-block d-md-none mx-auto">
            </li>
            <li class="nav-item"><a class="nav-link text-white" href="#"><p class="text-white p-0 m-0">アクセス</p><p class="p-0 m-0 fs-6 text-light-muted text-center text-uppercase">ACCESS</p></a><hr class="text-light-hr p-0 m-0 d-block d-md-none mx-auto"></li>
            <li class="nav-item"><a class="nav-link text-white" href="#"><p class="text-white p-0 m-0">スタッフ</p><p class="p-0 m-0 fs-6 text-light-muted text-center text-uppercase">STAFF</p></a><hr class="text-light-hr p-0 m-0 d-block d-md-none mx-auto"></li>
            <!-- <li class="nav-item"><a class="nav-link text-white" href="{{ route('admin.login') }}"><p class="text-white p-0 m-0">管理者ログイン</p><p class="p-0 m-0 fs-6 text-light-muted text-center text-uppercase">ADMIN LOGIN</p></a></li> -->
            <hr class="text-light-hr p-0 m-0 d-block d-md-none mx-auto">
        </ul>
    </div>
</nav>
