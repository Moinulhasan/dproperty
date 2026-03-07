@extends('admin.master')

@section('content')
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Add Company</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.company.add.post') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="company-name">Company Name</label>
                            <input type="text" class="form-control" id="company-name" name="name" placeholder="Enter company name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="company-email">Email</label>
                            <input type="email" class="form-control" id="company-email" name="email" placeholder="Enter company email" value="{{ old('email') }}">
                            @error('email')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="company-phone">Phone</label>
                            <input type="text" class="form-control" id="company-phone" name="phone" placeholder="Enter company phone" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="company-address">Address</label>
                            <textarea class="form-control" id="company-address" name="address" placeholder="Enter company address">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="company-logo">Logo</label>
                            <input type="file" class="form-control" id="company-logo" name="logo">
                            @error('logo')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="company-status">Status</label>
                            <select class="form-select" id="company-status" name="status" required>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Save Company</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
