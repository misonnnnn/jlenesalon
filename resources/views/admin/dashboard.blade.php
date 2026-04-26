@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('admin-content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h4>Welcome, {{ auth()->user()->name }}</h4>
            <p class="text-muted">Manage salon CMS content from here.</p>
            <a href="{{ route('admin.services.index') }}" class="btn btn-dark">Manage Services</a>
        </div>
    </div>
@endsection
