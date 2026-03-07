@extends('admin.master')

@section('content')
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Add Permission</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.permission.add.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="permission-name">Permission Name</label>
                            <input type="text" class="form-control" id="permission-name" name="name" placeholder="Enter permission name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Save Permission</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
