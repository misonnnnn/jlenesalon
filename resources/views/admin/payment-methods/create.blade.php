@extends('admin.layouts.app')

@section('title', 'Add Payment Method')

@section('admin-content')
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-page-title mb-0">Create Payment Method</h3>
        </div>
        <div class="p-4">
            <form action="{{ route('admin.payments.store') }}" method="POST">
                @include('admin.payment-methods._form', ['submitLabel' => 'Create'])
            </form>
        </div>
    </div>
@endsection
