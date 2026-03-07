@extends('admin.master')

@section('content')
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Add Role</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.role.add.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="role-name">Role Name</label>
                            <input type="text" class="form-control" id="role-name" name="name" placeholder="Enter role name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Permissions</label>
                            <div class="row">
                                @foreach($permissions as $permission)
                                    <div class="col-md-3 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="perm-{{ $permission->id }}">
                                            <label class="form-check-label" for="perm-{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Role</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
