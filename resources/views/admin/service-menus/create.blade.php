@extends('admin.layouts.app')

@section('title', 'Create Service Menu')

@section('admin-content')
    <h3>Create Menu for {{ $service->name_en }}</h3>
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
            <form action="{{ route('admin.services.menus.store', $service) }}" method="POST" enctype="multipart/form-data">
                @include('admin.service-menus._form', ['submitLabel' => 'Create Menu'])
            </form>
        </div>
    </div>
@endsection
