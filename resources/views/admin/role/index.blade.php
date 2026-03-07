@extends('admin.master')

@section('content')
    @include('admin.include.alert')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Role List</h5>
            <a href="{{ route('admin.role.add') }}" class="btn btn-primary">Add Role</a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Permissions</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>
                                @foreach($role->permissions as $permission)
                                    <span class="badge bg-label-primary">{{ $permission->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('admin.role.edit', $role->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <a href="{{ route('admin.role.delete', $role->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $roles->links() }}
        </div>
    </div>
@endsection
