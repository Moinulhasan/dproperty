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
                    <h5>Service List</h5>
                </div>
                <div class="col-md-6 user_role" style="text-align: right">
                    <a href="{{route('admin.service.add')}}" class="btn btn-label-primary">Add Service</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-datatable table-responsive">
                <table class="datatables-sliders table" id="sliderList">
                    <thead class="border-top">
                    <tr>
                        <th>Title</th>
                        <th class="text-center">Short Description</th>
                        <th class="text-center">Image</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($services))
                        @foreach($services as $service)
                            <tr>
                                <td>{{$service->title}}</td>
                                <td>{{$service->description}}</td>
                                <td>
                                    @if($service->image)
                                        <img src="{{$service->image}}" alt="service image"
                                             style="width: 100px; height: 60px;">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td>
                                    @switch($service->status)
                                        @case(1)
                                            <span class="badge bg-label-success">Active</span>
                                            @break
                                        @case(0)
                                            <span class="badge bg-label-danger">Inactive</span>
                                            @break
                                        @default
                                            <span class="badge bg-label-secondary">Unknown</span>
                                    @endswitch
                                </td>
                                <td>{{$service->user->name}}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <a href="{{route('admin.service.edit',$service)}}"
                                           class="btn btn-sm btn-icon btn-primary me-2" title="Edit Service">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <a href="{{route('admin.service.delete',$service)}}" class="btn btn-sm btn-icon btn-primary me-2" title="Edit Service">
                                            <i class="ti ti-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{$services->links()}}
            </div>
        </div>
    </div>
@endsection
