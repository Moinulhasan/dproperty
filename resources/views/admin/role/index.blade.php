@extends('admin.master')

@section('content')
    @include('admin.include.alert')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Role List</h5>
            <a href="{{ route('admin.role.add') }}" class="btn btn-primary">Add Role</a>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th width="20%">Name</th>
                        <th width="60%">Permissions</th>
                        <th width="20%">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td class="text-wrap">
                                @foreach($role->permissions as $permission)
                                    <span class="badge bg-label-primary mb-1">{{ $permission->name }}</span>
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
