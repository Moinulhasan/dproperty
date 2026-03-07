@extends('admin.master')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">User List</h5>
            <a href="{{ route('admin.user.add') }}" class="btn btn-primary">Add User</a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Company</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($users as $user)
                        <tr>
                            <td>
                                @if($user->avatar)
                                    <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" width="40" class="rounded-circle">
                                @else
                                    <div class="avatar-initial rounded-circle bg-label-primary text-center pt-1" style="width: 40px; height: 40px;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <span class="fw-semibold">{{ $user->name }}</span>
                                @if($user->is_verified)
                                    <i class="ti ti-circle-check text-success ms-1" title="Verified"></i>
                                @endif
                                <br>
                                <small class="text-muted">ID: {{ $user->agent_id ?? 'N/A' }}</small>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-label-info text-capitalize">
                                    {{ $user->roles->first()?->name ?? 'No Role' }}
                                </span>
                            </td>
                            <td>{{ $user->company?->name ?? 'Independent' }}</td>
                            <td>
                                <span class="badge bg-label-{{ $user->status == 'active' ? 'success' : 'danger' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-sm btn-icon btn-primary me-2" title="Edit">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.user.delete', $user->id) }}" class="btn btn-sm btn-icon btn-danger" onclick="return confirm('Are you sure?')" title="Delete">
                                        <i class="ti ti-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $users->links() }}
        </div>
    </div>
@endsection
