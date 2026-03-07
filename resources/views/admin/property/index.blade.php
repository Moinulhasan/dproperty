@extends('admin.master')

@section('content')
    @include('admin.include.alert')
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.property.list') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Search by title..." value="{{ request('title') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Type</label>
                    <select name="property_type" class="form-select">
                        <option value="">All Types</option>
                        <option value="Apartment" {{ request('property_type') == 'Apartment' ? 'selected' : '' }}>Apartment</option>
                        <option value="House" {{ request('property_type') == 'House' ? 'selected' : '' }}>House</option>
                        <option value="Land" {{ request('property_type') == 'Land' ? 'selected' : '' }}>Land</option>
                        <option value="Office" {{ request('property_type') == 'Office' ? 'selected' : '' }}>Office</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="property_status" class="form-select">
                        <option value="">All Status</option>
                        <option value="Buy" {{ request('property_status') == 'Buy' ? 'selected' : '' }}>Buy</option>
                        <option value="Rent" {{ request('property_status') == 'Rent' ? 'selected' : '' }}>Rent</option>
                        <option value="Sell" {{ request('property_status') == 'Sell' ? 'selected' : '' }}>Sell</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" placeholder="Search by route/sub-route..." value="{{ request('location') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100 me-2"><i class="ti ti-search me-1"></i> Filter</button>
                    <a href="{{ route('admin.property.list') }}" class="btn btn-label-secondary w-100"><i class="ti ti-refresh me-1"></i> Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Property List</h5>
            <a href="{{ route('admin.property.add') }}" class="btn btn-primary">Add Property</a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th style="max-width: 250px;">Title</th>
                        <th>Type/Status</th>
                        <th>Price</th>
                        <th>Location</th>
                        <th>Creator (Company)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($properties as $property)
                        <tr>
                            <td>
                                @if ($property->images && count($property->images) > 0)
                                    <img src="{{ asset($property->images[0]) }}" alt="{{ $property->title }}" width="70"
                                        height="50" style="object-fit: cover" class="rounded">
                                @else
                                    <div class="bg-label-secondary rounded d-flex align-items-center justify-content-center"
                                        style="width: 70px; height: 50px;">
                                        <i class="ti ti-camera"></i>
                                    </div>
                                @endif
                            </td>
                            <td style="max-width: 250px; white-space: normal;">
                                <span class="fw-semibold" title="{{ $property->title }}">{{ Str::limit($property->title, 45) }}</span>
                                <br>
                                <small class="text-muted">ID: {{ $property->project_id }}</small>
                            </td>
                            <td>
                                <span class="badge bg-label-info">{{ $property->property_type }}</span>
                                <br>
                                <span class="badge bg-label-{{ $property->property_status == 'Rent' ? 'success' : 'primary' }} mt-1">{{ $property->property_status }}</span>
                            </td>
                            <td>{{ number_format($property->price) }} BDT</td>
                            <td style="white-space: normal;">
                                <i class="ti ti-map-pin me-1 text-danger"></i>
                                <small>{{ $property->route }}{{ $property->sub_route ? ', ' . $property->sub_route : '' }}</small>
                            </td>
                            <td>
                                <strong>{{ $property->user?->name ?? 'Deleted User' }}</strong>
                                <br>
                                <small class="text-muted">{{ $property->user?->company?->name ?? 'Independent' }}</small>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('admin.property.edit', $property->id) }}"
                                        class="btn btn-sm btn-icon btn-primary me-2" title="Edit">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.property.delete', $property->id) }}"
                                        class="btn btn-sm btn-icon btn-danger" onclick="return confirm('Are you sure?')"
                                        title="Delete">
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
            {{ $properties->links() }}
        </div>
    </div>
@endsection
