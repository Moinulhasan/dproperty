@extends('admin.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Amenity List</h5>
            <a href="{{ route('admin.amenity.add') }}" class="btn btn-primary">Add Amenity</a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="10%">Icon</th>
                        <th>Name</th>
                        <th width="20%">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($amenities as $amenity)
                        <tr>
                            <td>
                                @if($amenity->icon)
                                    <i class="{{ $amenity->icon }} fa-2x text-primary"></i>
                                @else
                                    <span class="text-muted">No Icon</span>
                                @endif
                            </td>
                            <td><strong>{{ $amenity->name }}</strong></td>
                            <td>
                                <a href="{{ route('admin.amenity.edit', $amenity->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <a href="{{ route('admin.amenity.delete', $amenity->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No amenities found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
