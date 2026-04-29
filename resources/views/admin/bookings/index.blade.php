@extends('admin.layouts.app')

@section('title', 'Bookings')

@section('admin-content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="admin-page-title">Bookings</h3>
        <button class="btn btn-admin-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#bookingCalendarModal">
            <i class="fa fa-calendar me-1"></i> View Calendar
        </button>
    </div>

    <div class="admin-card">
        <div class="card-body p-0">
            @if ($bookings->isEmpty())
                <div class="p-4">
                    <p class="admin-muted mb-0">No booking requests yet.</p>
                </div>
            @else
                <div class="table-responsive p-3">
                    <table class="table table-hover mb-0 align-middle admin-table">
                        <thead>
                            <tr>
                                <th>When</th>
                                <th>Service / Menu</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Method</th>
                                <th>Actions</th>
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
                                        <div class="fw-semibold  fw-bold">{{ $svc?->name_en ?? '—' }}</div>
                                        <div class="small admin-muted">{{ $menu?->title_en ?? $menu?->title ?? '—' }}</div>
                                    </td>
                                    <td> <strong >{{ ucwords(strtolower($booking->customer_name)) }}</strong> 
                                        <div class="small">
                                            <p class="m-0 text-muted small">{{ $booking->customer_email }}</p>
                                            @if ($booking->customer_phone)
                                                <div class="small admin-muted">{{ $booking->customer_phone }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td><span class="badge-soft text-uppercase small">{{ $booking->status }}</span></td>
                                    <td><span class="badge-soft text-uppercase small {{$booking->payment_status == 'paid' ? 'text-success' : 'text-danger'}}    ">{{ $booking->payment_status ?? 'unpaid' }}</span></td>
                                    <td><span class="badge-soft text-uppercase small">{{ $booking->payment_method ?? 'card' }}</span></td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-outline-primary"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="btn btn-sm btn-admin-primary"><i class="fa fa-eye"></i></a>
                                        <!-- <a href="#" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></a> -->
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="modal fade" id="bookingCalendarModal" tabindex="-1" aria-labelledby="bookingCalendarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingCalendarModalLabel">Booking Availability Calendar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex gap-3 small mb-2">
                        <span><span class="badge-soft">Booked</span></span>
                        <span class="text-muted">Available slots are empty blocks during business hours (Mon-Sat, 09:00-19:00).</span>
                    </div>
                    <div id="bookingCalendar"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
    <style>
        #bookingCalendar .fc-toolbar-title {
            font-size: 1.1rem;
            font-weight: 600;
        }
        #bookingCalendar .fc-event {
            border-radius: 8px;
            padding: 1px 3px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('bookingCalendar');
            var modalEl = document.getElementById('bookingCalendarModal');
            if (!calendarEl || !modalEl || typeof FullCalendar === 'undefined') {
                return;
            }

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 700,
                allDaySlot: false,
                nowIndicator: true,
                slotMinTime: '09:00:00',
                slotMaxTime: '19:00:00',
                slotDuration: '00:30:00',
                businessHours: {
                    daysOfWeek: [1, 2, 3, 4, 5, 6],
                    startTime: '09:00',
                    endTime: '19:00',
                },
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: {
                    url: @json(route('admin.bookings.events')),
                    method: 'GET',
                    failure: function () {
                        alert('Failed to load booking events.');
                    }
                },
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true
                }
            });

            modalEl.addEventListener('shown.bs.modal', function () {
                calendar.render();
                calendar.refetchEvents();
                calendar.updateSize();
            });
        });
    </script>
@endpush
