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
                    <h5>About Us List</h5>
                </div>
                <div class="col-md-6 user_role" style="text-align: right">
                    <a href="{{route('admin.about_us.add')}}" class="btn btn-label-primary">Add New Section</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-datatable table-responsive">
                <table class="table" id="aboutUsList">
                    <thead class="border-top">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Created at</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(count($abouts))
                            @foreach($abouts as $key => $about)
                                <tr>
                                    <td>{{ $abouts->firstItem() + $key }}</td>
                                    <td>{{ $about->title }}</td>
                                    <td>
                                        @if($about->image)
                                            <img src="{{ asset($about->image) }}" alt="{{ $about->title }}" style="width: 100px; height: 60px; object-fit: cover; border-radius: 6px;">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($about->status == 1)
                                            <span class="badge bg-label-success">Active</span>
                                        @else
                                            <span class="badge bg-label-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{\Illuminate\Support\Carbon::parse($about->created_at)->diffForHumans()}}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{route('admin.about_us.edit', $about)}}" class="btn btn-sm btn-icon btn-primary me-2" title="Edit">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <a href="{{route('admin.about_us.delete', $about)}}" class="btn btn-sm btn-icon btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this?')">
                                                <i class="ti ti-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No sections found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{$abouts->links()}}
            </div>
        </div>
    </div>
@endsection
