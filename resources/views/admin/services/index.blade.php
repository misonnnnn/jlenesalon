@extends('admin.layouts.app')

@section('title', 'Manage Services')

@section('admin-content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="admin-page-title">Services</h3>
        <a href="{{ route('admin.services.create') }}" class="btn btn-admin-primary">Add Service</a>
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
        <div class="table-responsive">
            <table class="table mb-0 align-middle admin-table">
                <thead >
                    <tr>
                        <th>Icon</th>
                        <th>Name</th>
                        <th>Active</th>
                        <th>Sort</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($services as $service)
                        <tr class="p-2">
                            <td>@if ($service->icon_image)<img src="{{ asset($service->icon_image) }}" style="width:40px;height:40px;object-fit:cover;" alt="icon">@endif</td>
                            <td>
                                <strong>{{ $service->name_en }}</strong><br>
                                <small class="text-muted">{{ $service->name_ja }}</small>
                                </td>
                                <td>{{ $service->is_active ? 'Yes' : 'No' }}</td>
                            <td>{{ $service->sort_order }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.services.menus.index', $service) }}" class="btn btn-sm btn-outline-primary"><i class="fa fa-list"></i> Menus</a>
                                <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-primary"><i class="fa-regular fa-pen-to-square"></i></a>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this service?')" type="submit"> <i class="fa-regular fa-trash-can"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4">No services yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
