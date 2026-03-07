@extends('admin.master')

@section('content')
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Permission</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.permission.edit.post', $permission->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="permission-name">Permission Name</label>
                            <input type="text" class="form-control" id="permission-name" name="name" placeholder="Enter permission name" value="{{ old('name', $permission->name) }}" required>
                            @error('name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update Permission</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
