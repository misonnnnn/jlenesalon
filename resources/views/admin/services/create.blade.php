@extends('admin.layouts.app')

@section('title', 'Create Service')

@section('admin-content')
    <h3>Create Service</h3>
    <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary btn-sm mb-3">Back</a>

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
            <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
                @include('admin.services._form', ['submitLabel' => 'Create Service'])
            </form>
        </div>
    </div>
@endsection
