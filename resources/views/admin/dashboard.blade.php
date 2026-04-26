@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('admin-content')
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-page-title">Today</h3>
            <p class="admin-muted mb-0 mt-1">Welcome, {{ auth()->user()->name }}. Manage your website content and bookings.</p>
        </div>
        <div class="p-4">
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="admin-card p-3 h-100">
                        <div class="admin-muted small">Services</div>
                        <div class="h4 mb-0">{{ \App\Models\Service::count() }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-card p-3 h-100">
                        <div class="admin-muted small">Active Menus</div>
                        <div class="h4 mb-0">{{ \App\Models\ServiceMenu::where('is_active', true)->count() }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="admin-card p-3 h-100">
                        <div class="admin-muted small">Booking Requests</div>
                        <div class="h4 mb-0">{{ \App\Models\Booking::count() }}</div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.services.index') }}" class="btn btn-admin-primary">Manage Services</a>
                <a href="{{ route('admin.bookings') }}" class="btn btn-outline-secondary">View Bookings</a>
            </div>
        </div>
    </div>
@endsection
