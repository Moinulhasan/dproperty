@extends('admin.master')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Permission List</h5>
            <a href="{{ route('admin.permission.add') }}" class="btn btn-primary">Add Permission</a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($permissions as $permission)
                        <tr>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.permission.edit', $permission->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <a href="{{ route('admin.permission.delete', $permission->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $permissions->links() }}
        </div>
    </div>
@endsection
