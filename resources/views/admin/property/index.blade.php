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
                    <a href="{{route('admin.property.add')}}" class="btn btn-label-primary">Add Property</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-datatable table-responsive">
                <table class="datatables-sliders table" id="sliderList">
                    <thead class="border-top">
                    <tr>
                        <th>Property Link</th>
                        <th>Content</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($properties))
                        @foreach($properties as $propertie)
                            <tr>
                                <td>
                                    @if($propertie->type == 'fb')
                                        <a href="{{$propertie->link}}" target="_blank">Facebook</a>
                                    @elseif($propertie->type == 'yu')
                                        <a href="{{$propertie->link}}" target="_blank">Youtube</a>
                                    @else
                                        <span class="text-muted">Unknown Type</span>
                                    @endif
                                </td>
                                <td>{{Str::limit($propertie->description,120,'......')}}</td>
                                <td>
                                    @switch($propertie->status)
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
                                    <div class="d-flex justify-content-center">
                                        <a href="{{route('admin.property.edit',$propertie)}}"
                                           class="btn btn-sm btn-primary me-2">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <a href="#"
                                           class="btn btn-sm btn-danger me-2">
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
