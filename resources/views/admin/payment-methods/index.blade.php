@extends('admin.layouts.app')

@section('title', 'Payment Methods')

@section('admin-content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="admin-page-title">Payment Methods</h3>
        <a href="{{ route('admin.payments.create') }}" class="btn btn-sm btn-admin-primary">Add Payment Method</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="admin-card">
        <div class="table-responsive p-3">
            <table class="table mb-0 align-middle admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Stripe</th>
                        <th>Active</th>
                        <th>Sort</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($paymentMethods as $payment)
                        <tr>
                            <td>
                                <strong>{{ $payment->name }}</strong>
                                @if ($payment->notes)
                                    <br><small class="text-muted">{{ $payment->notes }}</small>
                                @endif
                            </td>
                            <td><code>{{ $payment->code }}</code></td>
                            <td>{{ $payment->stripe_method ?: '-' }}</td>
                            <td>{!! $payment->is_active ? '<span class="badge badge-sm rounded-pill badge-soft text-uppercase small text-success">Active</span>' : '<span class="badge badge-sm rounded-pill badge-soft text-uppercase small text-danger">Inactive</span>' !!}</td>
                            <td>{{ $payment->sort_order }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.payments.edit', $payment) }}" class="btn btn-sm btn-primary">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Delete this payment method?')">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">No payment methods yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
