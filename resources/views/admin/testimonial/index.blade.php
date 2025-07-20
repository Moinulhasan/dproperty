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
                    <h5>Review List</h5>
                </div>
                <div class="col-md-6 user_role" style="text-align: right">
                    <a href="{{route('admin.testimonial.add')}}" class="btn btn-label-primary">Add Review</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-datatable table-responsive">
                <table class="datatables-sliders table" id="sliderList">
                    <thead class="border-top">
                    <tr>
                        <th>Client Name</th>
                        <th class="text-center">Designation</th>
                        <th class="text-center">Avatar</th>
                        <th class="text-center">Comment</th>
                        <th class="text-center">Social Link</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($testimonials))
                        @foreach($testimonials as $testimonial)
                            <tr>
                                <td>{{$testimonial->name}}</td>
                                <td>{{$testimonial->designation}}</td>
                                <td>
                                    <div class="avatar avatar-lg me-2">
                                        <img src="{{$testimonial->image}}" alt="avatar" class="rounded-circle">
                                    </div>
                                </td>
                                <td>
                                    {{ Str::limit($testimonial->review,150,'........ more') }}
                                </td>
                                <td class="text-center">
                                    <a href="{{$testimonial->s_link}}" class="btn btn-sm btn-icon btn-primary me-2">
                                        <i class="ti ti-social"></i>
                                    </a>
                                </td>
                                <td>
                                    @switch($testimonial->status)
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
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <a href="{{route('admin.testimonial.edit',$testimonial)}}"
                                           class="btn btn-sm btn-icon btn-primary me-2" title="Edit Service">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <a href="{{route('admin.testimonial.delete',$testimonial)}}"
                                           class="btn btn-sm btn-icon btn-primary me-2" title="Edit Service">
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
        </div>
    </div>
@endsection
