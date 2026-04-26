@extends('admin.layouts.app')

@section('title', 'Bookings')

@section('admin-content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Bookings</h3>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            @if ($bookings->isEmpty())
                <div class="p-4">
                    <p class="text-muted mb-0">No booking requests yet.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>When</th>
                                <th>Service / Menu</th>
                                <th>Customer</th>
                                <th>Contact</th>
                                <th>Status</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                @php
                                    $menu = $booking->menu;
                                    $svc = $menu?->service;
                                @endphp
                                <tr>
                                    <td class="text-nowrap">{{ $booking->starts_at->timezone(config('app.timezone'))->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $svc?->name_en ?? '—' }}</div>
                                        <div class="small text-muted">{{ $menu?->title_en ?? $menu?->title ?? '—' }}</div>
                                    </td>
                                    <td>{{ $booking->customer_name }}</td>
                                    <td>
                                        <div class="small"><a href="mailto:{{ $booking->customer_email }}">{{ $booking->customer_email }}</a></div>
                                        @if ($booking->customer_phone)
                                            <div class="small text-muted">{{ $booking->customer_phone }}</div>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-secondary text-uppercase">{{ $booking->status }}</span></td>
                                    <td class="small text-muted" style="max-width: 220px;">{{ Str::limit($booking->notes, 120) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-3 border-top">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
