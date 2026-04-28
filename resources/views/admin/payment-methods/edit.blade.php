@extends('admin.layouts.app')

@section('title', 'Edit Payment Method')

@section('admin-content')
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-page-title mb-0">Edit Payment Method</h3>
        </div>
        <div class="p-4">
            <form action="{{ route('admin.payments.update', $payment) }}" method="POST">
                @method('PUT')
                @include('admin.payment-methods._form', ['submitLabel' => 'Update'])
            </form>
        </div>
    </div>
@endsection
