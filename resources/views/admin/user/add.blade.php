@extends('admin.master')

@section('content')
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Create User</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.user.add.post') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="user-name">Full Name</label>
                                <input type="text" class="form-control" id="user-name" name="name" placeholder="Enter full name" value="{{ old('name') }}" required>
                                @error('name')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="user-email">Email Address</label>
                                <input type="email" class="form-control" id="user-email" name="email" placeholder="Enter email address" value="{{ old('email') }}" required>
                                @error('email')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="user-password">Password</label>
                                <input type="password" class="form-control" id="user-password" name="password" placeholder="Enter password" required>
                                @error('password')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="user-phone">Phone Number</label>
                                <input type="text" class="form-control" id="user-phone" name="phone" placeholder="Enter phone number" value="{{ old('phone') }}">
                                @error('phone')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="user-whatsapp">WhatsApp Number</label>
                                <input type="text" class="form-control" id="user-whatsapp" name="whatsapp_number" placeholder="Enter WhatsApp number" value="{{ old('whatsapp_number') }}">
                                @error('whatsapp_number')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="user-role">Role</label>
                                <select class="form-select text-capitalize" id="user-role" name="role" required>
                                    <option value="">Select Role</option>
                                    @foreach($roles as $role)
                                        @php
                                            $isSuperAdminRole = ($role->name === 'Super Admin');
                                            $currentUserIsSuperAdmin = auth()->user()->hasRole('Super Admin');
                                        @endphp

                                        @if($currentUserIsSuperAdmin)
                                            @if($isSuperAdminRole)
                                                <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                                            @endif
                                        @else
                                            @if(!$isSuperAdminRole)
                                                <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                                @error('role')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                            </div>
                            @if(auth()->user()->hasRole('Super Admin'))
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="user-company">Company</label>
                                <select class="form-select" id="user-company" name="company_id">
                                    <option value="">Select Company (Optional)</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                                    @endforeach
                                </select>
                                @error('company_id')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                            </div>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="user-status">Status</label>
                                <select class="form-select" id="user-status" name="status" required>
                                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="user-avatar">Avatar</label>
                                <input type="file" class="form-control" id="user-avatar" name="avatar">
                                @error('avatar')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-3 form-check mt-3">
                            <input type="checkbox" class="form-check-input" id="is-verified" name="is_verified" value="1" {{ old('is_verified') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is-verified">Is Verified?</label>
                        </div>

                        <button type="submit" class="btn btn-primary">Create User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
