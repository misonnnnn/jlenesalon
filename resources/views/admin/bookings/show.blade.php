@extends('admin.layouts.app')

@section('title', 'Manage Booking')

@section('admin-content')
    @php
        $menu = $booking->menu;
        $service = $menu?->service;
        $currentStatus = old('status', $booking->status);
    @endphp

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <h3 class="admin-page-title mb-1">Manage Booking #{{ $booking->id }}</h3>
            <p class="admin-muted mb-0">Review customer details, update status, and reschedule appointment.</p>
        </div>
        <a href="{{ route('admin.bookings') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fa fa-arrow-left me-1"></i> Back to Bookings
        </a>
    </div>

    <div class="row g-3">
        <div class="col-xl-8">
            <div class="admin-card h-100">
                <div class="admin-card-header">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <h5 class="mb-0">Booking Details</h5>
                        <span class="badge-soft text-uppercase">{{ str_replace('_', ' ', $booking->status) }}</span>
                    </div>
                </div>
                <div class="p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="border rounded p-3 h-100">
                                <div class="small admin-muted mb-1">Service</div>
                                <div class="fw-semibold">{{ $service?->name_en ?? '—' }}</div>
                                <div class="small text-muted">{{ $service?->name_ja ?? '' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border rounded p-3 h-100">
                                <div class="small admin-muted mb-1">Menu</div>
                                <div class="fw-semibold">{{ $menu?->title_en ?? $menu?->title ?? '—' }}</div>
                                <div class="small text-muted">{{ $menu?->title_ja ?? $menu?->title ?? '' }}</div>
                            </div>
                        </div>
                    </div>

                    <dl class="row mb-0">
                        <dt class="col-sm-4">Customer</dt>
                        <dd class="col-sm-8">{{ ucwords(strtolower($booking->customer_name)) }}</dd>

                        <dt class="col-sm-4">Email / Phone</dt>
                        <dd class="col-sm-8">
                            <div>{{ $booking->customer_email }}</div>
                            <div class="small text-muted">{{ $booking->customer_phone ?: 'No phone provided' }}</div>
                        </dd>

                        <dt class="col-sm-4">Scheduled At</dt>
                        <dd class="col-sm-8">{{ $booking->starts_at?->timezone(config('app.timezone'))->format('Y-m-d h:i A') }}</dd>

                        <dt class="col-sm-4">Payment</dt>
                        <dd class="col-sm-8 text-uppercase">
                            {{ $booking->payment_status ?: 'unpaid' }} via {{ $booking->payment_method ?: 'card' }}
                        </dd>

                        <dt class="col-sm-4">Created</dt>
                        <dd class="col-sm-8">{{ $booking->created_at?->timezone(config('app.timezone'))->format('Y-m-d h:i A') }}</dd>

                        <dt class="col-sm-4">Notes</dt>
                        <dd class="col-sm-8">{{ $booking->notes ?: '—' }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h5 class="mb-0">Status Settings</h5>
                </div>
                <div class="p-4">
                    <form method="post" action="{{ route('admin.bookings.update', $booking) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="starts_at" value="{{ $booking->starts_at?->format('Y-m-d\TH:i') }}">

                        <div class="mb-2">
                            <label class="form-label fw-semibold" for="status">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                @foreach ($allowedStatuses as $status)
                                    <option value="{{ $status }}" @selected($currentStatus === $status)>
                                        {{ strtoupper(str_replace('_', ' ', $status)) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-admin-primary w-100">
                            Update Status
                        </button>
                    </form>
                </div>
            </div>

            <div class="admin-card mt-3">
                <div class="admin-card-header">
                    <h5 class="mb-0">Reschedule Settings</h5>
                </div>
                <div class="p-4">
                    <form method="post" action="{{ route('admin.bookings.update', $booking) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="{{ $currentStatus }}">

                        <div class="mb-2">
                            <label class="form-label fw-semibold" for="starts_at">New Date and Time</label>
                            <input
                                type="datetime-local"
                                class="form-control @error('starts_at') is-invalid @enderror"
                                id="starts_at"
                                name="starts_at"
                                value="{{ old('starts_at', $booking->starts_at?->format('Y-m-d\\TH:i')) }}"
                                required
                            >
                            @error('starts_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-outline-primary w-100">
                            Save New Schedule
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
