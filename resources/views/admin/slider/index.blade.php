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
                    <h5>Slider List</h5>
                </div>
                <div class="col-md-6 user_role" style="text-align: right">
                    <a href="{{route('admin.slider.add')}}" class="btn btn-label-primary">Add Slider</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-datatable table-responsive">
                <table class="datatables-sliders table" id="sliderList">
                    <thead class="border-top">
                    <tr>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Created at</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(count($sliders))
                            @foreach($sliders as $slider)
                                <tr>
                                    <td>{{$slider->title}}</td>
                                    <td>
                                        @if($slider->image)
                                            <img src="{{$slider->image}}" alt="slider image" style="width: 100px; height: 60px;">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    <td>
                                        @switch($slider->status)
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
                                    <td>
                                        {{$slider->user ? $slider->user->name : 'N/A'}}
                                    </td>
                                    <td>{{\Illuminate\Support\Carbon::parse($slider->created_at)->diffForHumans()}}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{route('admin.slider.edit', $slider)}}" class="btn btn-sm btn-icon btn-primary me-2" title="Edit Slider">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <a href="{{route('admin.slider.delete', $slider)}}" class="btn btn-sm btn-icon btn-primary me-2" title="Delete Slider">
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
                {{$sliders->links()}}
            </div>
        </div>
    </div>
@endsection
