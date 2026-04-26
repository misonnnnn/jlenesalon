@extends('admin.layouts.app')

@section('title', 'Edit Service Menu')

@section('admin-content')
    <h3>Edit Menu for {{ $service->name_en }}</h3>
    <a href="{{ route('admin.services.menus.index', $service) }}" class="btn btn-outline-secondary btn-sm mb-3">Back</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.services.menus.update', [$service, $menu]) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @include('admin.service-menus._form', ['submitLabel' => 'Save Changes'])
            </form>
        </div>
    </div>
@endsection
