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
                    <h5>Service Tag List</h5>
                </div>
                <div class="col-md-6 user_role" style="text-align: right">
                    <a href="{{route('admin.tag.add')}}" class="btn btn-label-primary">Add Tags</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-datatable table-responsive">
                <table class="datatables-sliders table" id="sliderList">
                    <thead class="border-top">
                    <tr>
                        <th>Type</th>
                        <th class="text-center">Tag Line</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($tags))
                        @foreach($tags as $tag)
                            <tr>
                                <td>{{$tag->service_type}}</td>
                                <td class="text-center">{{$tag->tag_line}}</td>
                                <td>
                                    @switch($tag->status)
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
                                        <a href="{{route('admin.tag.edit',$tag)}}"
                                           class="btn btn-sm btn-icon btn-primary me-2" title="Edit Tag">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <a href="{{route('admin.tag.delete',$tag)}}"
                                           class="btn btn-sm btn-icon btn-primary me-2" title="Delete Tag">
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
                {{$tags->links()}}
            </div>
        </div>
    </div>
@endsection
