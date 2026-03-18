@extends('admin.master')

@section('content')
    @if(session()->get('success'))
        <div class="alert alert-success" role="alert">{{session()->get('success')}}</div>
    @endif
    @if(session()->get('errors'))
        <div class="alert alert-danger" role="alert">{{session()->get('errors')->first()}}</div>
    @endif
    <div class="card">
        <div class="card-header border-bottom">
            <div class="d-flex justify-content-between row pb-2 gap-3 gap-md-0 w-100">
                <div class="col-md-6">
                    <h5>Location List</h5>
                </div>
                <div class="col-md-6 user_role" style="text-align: right">
                    <a href="{{route('admin.location.add')}}" class="btn btn-label-primary">Add Location</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-datatable table-responsive">
                <table class="table" id="locationList">
                    <thead class="border-top">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Properties</th>
                        <th>Created at</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(count($locations))
                            @foreach($locations as $key => $location)
                                <tr>
                                    <td>{{ $locations->firstItem() + $key }}</td>
                                    <td>{{ $location->name }}</td>
                                    <td>
                                        @if($location->image)
                                            <img src="{{ asset($location->image) }}" alt="{{ $location->name }}" style="width: 100px; height: 60px; object-fit: cover; border-radius: 6px;">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($location->status == 1)
                                            <span class="badge bg-label-success">Active</span>
                                        @else
                                            <span class="badge bg-label-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-label-info">{{ $location->properties()->count() }}</span>
                                    </td>
                                    <td>{{\Illuminate\Support\Carbon::parse($location->created_at)->diffForHumans()}}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{route('admin.location.edit', $location)}}" class="btn btn-sm btn-icon btn-primary me-2" title="Edit Location">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <a href="{{route('admin.location.delete', $location)}}" class="btn btn-sm btn-icon btn-danger" title="Delete Location" onclick="return confirm('Are you sure you want to delete this location?')">
                                                <i class="ti ti-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No locations found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{$locations->links()}}
            </div>
        </div>
    </div>
@endsection
