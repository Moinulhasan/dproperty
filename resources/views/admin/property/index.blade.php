@extends('admin.master')

@section('content')
    @include('admin.include.alert')
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ url()->current() }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Search by title..." value="{{ request('title') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Category</label>
                    <select name="property_category_id" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $parent)
                            <optgroup label="{{ $parent->name }}">
                                <option value="{{ $parent->id }}" {{ request('property_category_id') == $parent->id ? 'selected' : '' }}>{{ $parent->name }} (All)</option>
                                @foreach($parent->children as $child)
                                    <option value="{{ $child->id }}" {{ request('property_category_id') == $child->id ? 'selected' : '' }}>{{ $child->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
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
                    <select name="location_id" class="form-select">
                        <option value="">All Locations</option>
                        @foreach($locations as $loc)
                            <option value="{{ $loc->id }}" {{ request('location_id') == $loc->id ? 'selected' : '' }}>{{ $loc->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100 me-2"><i class="ti ti-search me-1"></i> Filter</button>
                    <a href="{{ url()->current() }}" class="btn btn-label-secondary w-100"><i class="ti ti-refresh me-1"></i> Reset</a>
                </div>
            </form>
        </div>
    </div>

    @php
        // Same view powers the standard list and the home-featured-only list.
        $featuredOnly = $featuredOnly ?? false;
        $addUrl = $featuredOnly
            ? route('admin.property.add') . '?featured=1'
            : route('admin.property.add');
    @endphp
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ $featuredOnly ? 'Featured Properties' : 'Property List' }}</h5>
            <a href="{{ $addUrl }}" class="btn btn-primary">{{ $featuredOnly ? 'Add New Feature' : 'Add Property' }}</a>
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
                        <th>State</th>
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
                                @if($property->is_featured || $property->is_home_featured || $property->is_location_featured)
                                    <div class="mt-1 d-flex flex-wrap gap-1">
                                        @if($property->is_featured)
                                            <span class="badge bg-label-warning" title="General Featured"><i class="ti ti-star ti-xs me-1"></i>General</span>
                                        @endif
                                        @if($property->is_home_featured)
                                            <span class="badge bg-label-danger" title="Home Featured"><i class="ti ti-home ti-xs me-1"></i>Home</span>
                                        @endif
                                        @if($property->is_location_featured)
                                            <span class="badge bg-label-dark" title="Location Featured"><i class="ti ti-map-pin ti-xs me-1"></i>Location</span>
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td>{{ number_format($property->price) }} BDT</td>
                            <td style="white-space: normal;">
                                <i class="ti ti-map-pin me-1 text-danger"></i>
                                <small>{{ $property->displayLocation() ?? '—' }}</small>
                            </td>
                            <td>
                                <strong>{{ $property->user?->name ?? 'Deleted User' }}</strong>
                                <br>
                                <small class="text-muted">{{ $property->user?->company?->name ?? 'Independent' }}</small>
                            </td>
                            <td>
                                @if($property->status)
                                    <span class="badge bg-label-success">Active</span>
                                @else
                                    <span class="badge bg-label-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex">
                                    <form action="{{ route('admin.property.toggle-status', $property->id) }}" method="POST" class="d-inline me-2">
                                        @csrf
                                        @if($property->status)
                                            <button type="submit" class="btn btn-sm btn-icon btn-warning" title="Deactivate" onclick="return confirm('Deactivate this property? It will be hidden from the public site.');">
                                                <i class="ti ti-eye-off"></i>
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-sm btn-icon btn-success" title="Activate" onclick="return confirm('Activate this property?');">
                                                <i class="ti ti-eye"></i>
                                            </button>
                                        @endif
                                    </form>
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
