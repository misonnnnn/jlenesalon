<!DOCTYPE html>
@php
    $locale = \App\Models\SiteSetting::isLanguageSelectorEnabled() ? session('site_locale', 'ja') : 'en';
    $isJa = $locale === 'ja';
    $menusByService = $services->mapWithKeys(function ($svc) use ($isJa) {
        return [
            $svc->slug => $svc->menus->map(function ($m) use ($isJa) {
                return [
                    'id' => $m->id,
                    'label' => $isJa ? ($m->title_ja ?? $m->title) : ($m->title_en ?? $m->title),
                    'meta' => trim(implode(' · ', array_filter([$m->duration, $m->price]))),
                ];
            })->values(),
        ];
    });
    $t = [
        'title' => $isJa ? 'ご予約' : 'Book an appointment',
        'subtitle' => $isJa ? 'メニューとご希望の日時をお選びください。' : 'Choose a menu and your preferred date and time.',
        'service' => $isJa ? 'サービス' : 'Service category',
        'menu' => $isJa ? 'メニュー' : 'Treatment menu',
        'select_service' => $isJa ? 'カテゴリを選択' : 'Select a category',
        'select_menu' => $isJa ? 'メニューを選択' : 'Select a menu',
        'datetime' => $isJa ? 'ご希望日時' : 'Preferred date & time',
        'name' => $isJa ? 'お名前' : 'Full name',
        'email' => $isJa ? 'メールアドレス' : 'Email',
        'phone' => $isJa ? '電話番号（任意）' : 'Phone (optional)',
        'payment_method' => $isJa ? 'お支払い方法' : 'Payment method',
        'select_payment_method' => $isJa ? '支払い方法を選択' : 'Select payment method',
        'payment_note' => $isJa ? 'お支払い方法は今後順次追加予定です。' : 'More payment methods will be added over time.',
        'notes' => $isJa ? 'ご要望・備考（任意）' : 'Notes or requests (optional)',
        'submit' => $isJa ? '支払いへ進む' : 'Continue to payment',
        'success' => $isJa
            ? 'お支払いありがとうございます。予約リクエストを受け付けました。内容を確認のうえご連絡いたします。'
            : 'Payment received. Your booking request was submitted successfully.',
        'no_menus' => $isJa ? 'このカテゴリにはメニューがありません。' : 'No menus are available for this category.',
    ];
@endphp
<html lang="{{ $locale }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <title>{{ $t['title'] }} | Jlene Salon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .booking-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,.08);
        }
        .booking-page-title {
            color: #201c1c;
        }
        .btn-booking-submit {
            /* background-color: #b49d59; */
            background-color: #000;
            border-color: #b49d59;
            color: #fff;
        }
        .btn-booking-submit:hover {
            /* background-color: #9a8548; */
            background-color: #444;
            border-color: #9a8548;
            color: #fff;
        }
    </style>
</head>
<body style="background: #f0f1f3;">
    @include('partials.site-header', ['services' => $services, 'isHomeHeader' => false])

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="booking-page-title mb-2">{{ $t['title'] }}</h1>
                <p class="text-muted mb-4">{{ $t['subtitle'] }}</p>

                @if (session('status') === 'booking_submitted')
                    <div class="alert alert-success border-0 shadow-sm" role="alert">
                        <i class="fa-solid fa-circle-check me-2"></i>{{ $t['success'] }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="booking-card p-4 p-md-5">
                    <form method="post" action="{{ route('bookings.store') }}" id="bookingForm" novalidate>
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-semibold" for="service_select">{{ $t['service'] }}</label>
                            <select class="form-select form-select-lg" id="service_select" autocomplete="off">
                                <option value="">{{ $t['select_service'] }}</option>
                                @foreach ($services as $svc)
                                    <option value="{{ $svc->slug }}" @selected($preselectedService === $svc->slug)>
                                        {{ $isJa ? $svc->name_ja : $svc->name_en }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold" for="service_menu_id">{{ $t['menu'] }}</label>
                            <select class="form-select form-select-lg @error('service_menu_id') is-invalid @enderror"
                                id="service_menu_id" name="service_menu_id" required disabled>
                                <option value="">{{ $t['select_menu'] }}</option>
                            </select>
                            @error('service_menu_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <p class="form-text text-muted small mb-0 d-none" id="menu_empty_hint">{{ $t['no_menus'] }}</p>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold" for="starts_at">{{ $t['datetime'] }}</label>
                            <input type="text" class="form-control form-control-lg @error('starts_at') is-invalid @enderror"
                                id="starts_at" name="starts_at" value="{{ old('starts_at') }}"
                                placeholder="{{ $isJa ? '日付と時間を選択' : 'Pick date and time' }}" required autocomplete="off">
                            @error('starts_at')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="customer_name">{{ $t['name'] }}</label>
                            <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required maxlength="255">
                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="customer_email">{{ $t['email'] }}</label>
                            <input type="email" class="form-control @error('customer_email') is-invalid @enderror"
                                id="customer_email" name="customer_email" value="{{ old('customer_email') }}" required maxlength="255">
                            @error('customer_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="customer_phone">{{ $t['phone'] }}</label>
                            <input type="tel" class="form-control @error('customer_phone') is-invalid @enderror"
                                id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" maxlength="50">
                            @error('customer_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="payment_method">{{ $t['payment_method'] }}</label>
                            <select class="form-select @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required>
                                <option value="">{{ $t['select_payment_method'] }}</option>
                                @foreach ($paymentMethods as $method)
                                    <option value="{{ $method->code }}" @selected(old('payment_method', 'card') === $method->code)>
                                        {{ $method->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">{{ $t['payment_note'] }}</div>
                            @error('payment_method')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold" for="notes">{{ $t['notes'] }}</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes"
                                rows="3" maxlength="2000">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-lg btn-booking-submit rounded-pill px-5">
                            {{ $t['submit'] }} <i class="fa-regular fa-paper-plane ms-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
    @if ($isJa)
        <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/l10n/ja.js"></script>
    @endif
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

            var $serviceSelect = $("#service_select");
            var $menuSelect = $("#service_menu_id");
            var $menuEmptyHint = $("#menu_empty_hint");
            var preselectedMenuId = @json($preselectedMenu ? (int) $preselectedMenu : null);
            var oldMenuId = @json(old('service_menu_id') ? (int) old('service_menu_id') : null);
            var menusByService = @json($menusByService);
            var bookedSlots = new Set();

            function fillMenus(menus) {

                $menuSelect.empty().append($("<option>", { value: "", text: @json($t['select_menu']) }));
                if (!menus || !menus.length) {
                    $menuSelect.prop("disabled", true);
                    $menuEmptyHint.removeClass("d-none");
                    return;
                }
                $menuEmptyHint.addClass("d-none");
                menus.forEach(function (m) {
                    var label = m.label;
                    if (m.meta) {
                        label += " — " + m.meta;
                    }
                    $menuSelect.append($("<option>", { value: m.id, text: label }));
                });
                $menuSelect.prop("disabled", false);
                var pick = oldMenuId || preselectedMenuId;
                if (pick) {
                    $menuSelect.val(String(pick));
                }
            }

            function onServiceChange() {
                var serviceSlug = $serviceSelect.val();
                fillMenus(menusByService[serviceSlug] || []);
            }

            $serviceSelect.on("change", onServiceChange);
            // Only runs when a category is pre-selected (e.g. ?service=slug or old input), not on a blank form.
            if ($serviceSelect.val()) {
                onServiceChange();
            }

            var bookingPicker = null;

            function toSlotKey(date) {
                if (!(date instanceof Date) || Number.isNaN(date.getTime())) {
                    return '';
                }
                return date.getFullYear() + '-' +
                    String(date.getMonth() + 1).padStart(2, '0') + '-' +
                    String(date.getDate()).padStart(2, '0') + ' ' +
                    String(date.getHours()).padStart(2, '0') + ':' +
                    String(date.getMinutes()).padStart(2, '0');
            }

            function isBookedDate(date) {
                if (!(date instanceof Date) || Number.isNaN(date.getTime())) {
                    return false;
                }
                for (var h = 9; h < 19; h++) {
                    var d00 = new Date(date.getFullYear(), date.getMonth(), date.getDate(), h, 0, 0, 0);
                    var d30 = new Date(date.getFullYear(), date.getMonth(), date.getDate(), h, 30, 0, 0);
                    if (!bookedSlots.has(toSlotKey(d00)) || !bookedSlots.has(toSlotKey(d30))) {
                        return false;
                    }
                }
                return true;
            }

            function loadUnavailableSlots(start, end) {
                return $.getJSON(@json(route('bookings.unavailable-slots')), { start: start, end: end })
                    .done(function (response) {
                        bookedSlots = new Set((response && response.slots) || []);
                        if (bookingPicker) {
                            bookingPicker.redraw();
                        }
                    });
            }

            var fpOpts = {
                enableTime: true,
                time_24hr: false,
                minuteIncrement: 30,
                minDate: "today",
                minTime: "09:00",
                maxTime: "19:00",
                dateFormat: "Y-m-d H:i",
                altInput: true,
                altFormat: @json($isJa ? "Y年m月d日 H:i" : "F j, Y \\a\\t h:i K"),
                disableMobile: true,
                disable: [
                    function (date) {
                        return date.getDay() === 0 || isBookedDate(date);
                    }
                ],
                onOpen: function (selectedDates, dateStr, instance) {
                    var viewDate = instance.currentYear && instance.currentMonth >= 0
                        ? new Date(instance.currentYear, instance.currentMonth, 1)
                        : new Date();
                    var start = viewDate.getFullYear() + '-' + String(viewDate.getMonth() + 1).padStart(2, '0') + '-01';
                    var endDate = new Date(viewDate.getFullYear(), viewDate.getMonth() + 1, 0);
                    var end = endDate.getFullYear() + '-' + String(endDate.getMonth() + 1).padStart(2, '0') + '-' + String(endDate.getDate()).padStart(2, '0') + ' 23:59:59';
                    loadUnavailableSlots(start, end);
                },
                onMonthChange: function (selectedDates, dateStr, instance) {
                    var start = instance.currentYear + '-' + String(instance.currentMonth + 1).padStart(2, '0') + '-01';
                    var endDate = new Date(instance.currentYear, instance.currentMonth + 1, 0);
                    var end = endDate.getFullYear() + '-' + String(endDate.getMonth() + 1).padStart(2, '0') + '-' + String(endDate.getDate()).padStart(2, '0') + ' 23:59:59';
                    loadUnavailableSlots(start, end);
                },
                onChange: function (selectedDates, dateStr, instance) {
                    if (!selectedDates.length) {
                        return;
                    }
                    var slotKey = toSlotKey(selectedDates[0]);
                    if (bookedSlots.has(slotKey)) {
                        instance.clear();
                        alert(@json($isJa ? 'この日時はすでに予約済みです。別の日時を選択してください。' : 'This slot is already booked. Please choose another date and time.'));
                    }
                }
            };
            @if ($isJa)
            if (typeof flatpickr !== "undefined" && flatpickr.l10ns && flatpickr.l10ns.ja) {
                fpOpts.locale = flatpickr.l10ns.ja;
            }
            @endif
            bookingPicker = flatpickr("#starts_at", fpOpts);
            var now = new Date();
            var currentMonthStart = now.getFullYear() + '-' + String(now.getMonth() + 1).padStart(2, '0') + '-01';
            var currentMonthEndDate = new Date(now.getFullYear(), now.getMonth() + 1, 0);
            var currentMonthEnd = currentMonthEndDate.getFullYear() + '-' + String(currentMonthEndDate.getMonth() + 1).padStart(2, '0') + '-' + String(currentMonthEndDate.getDate()).padStart(2, '0') + ' 23:59:59';
            loadUnavailableSlots(currentMonthStart, currentMonthEnd);
        });
    </script>
</body>
</html>
