@extends('admin.layouts.app')

@section('title', 'Service Menus')

@section('admin-content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-0">{{ $service->name_en }} - Service Menus</h3>
            <small class="text-muted">{{ $service->name_ja }}</small>
        </div>
        <div>
            <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">Back to Services</a>
            <a href="{{ route('admin.services.menus.create', $service) }}" class="btn btn-dark">Add Menu</a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Duration</th>
                        <th>Price</th>
                        <th>Active</th>
                        <th>Sort</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($menus as $menu)
                        <tr>
                            <td>
                                <strong>{{ $menu->title_en ?? $menu->title }}</strong><br>
                                <small class="text-muted">{{ $menu->title_ja ?? $menu->title }}</small>
                            </td>
                            <td>{{ $menu->duration ?: '-' }}</td>
                            <td>{{ $menu->price ?: '-' }}</td>
                            <td>{{ $menu->is_active ? 'Yes' : 'No' }}</td>
                            <td>{{ $menu->sort_order }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.services.menus.edit', [$service, $menu]) }}" class="btn btn-sm btn-outline-dark">Edit</a>
                                <form action="{{ route('admin.services.menus.destroy', [$service, $menu]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this menu item?')" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4">No service menus yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
