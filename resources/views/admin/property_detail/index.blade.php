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
                    <h5>Property Detail Fields</h5>
                </div>
                <div class="col-md-6 user_role" style="text-align: right">
                    <a href="{{route('admin.property-detail.add')}}" class="btn btn-label-primary">Add Detail Field</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-datatable table-responsive">
                <table class="table" id="propertyDetailList">
                    <thead class="border-top">
                    <tr>
                        <th>Order</th>
                        <th>Icon</th>
                        <th>Name</th>
                        <th>Input Type</th>
                        <th>Options</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($details as $detail)
                            <tr>
                                <td>{{ $detail->sort_order }}</td>
                                <td>
                                    @if($detail->icon)
                                        <i class="{{ $detail->icon }} fa-lg"></i>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td><strong>{{ $detail->name }}</strong></td>
                                <td><span class="badge bg-label-info">{{ ucfirst($detail->input_type) }}</span></td>
                                <td>
                                    @if($detail->options)
                                        <small>{{ implode(', ', $detail->options) }}</small>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($detail->status == 1)
                                        <span class="badge bg-label-success">Active</span>
                                    @else
                                        <span class="badge bg-label-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{route('admin.property-detail.edit', $detail)}}" class="btn btn-sm btn-icon btn-primary me-2" title="Edit">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <a href="{{route('admin.property-detail.delete', $detail)}}" class="btn btn-sm btn-icon btn-danger" title="Delete" onclick="return confirm('Are you sure? This will delete all associated values.')">
                                            <i class="ti ti-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No detail fields created yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{$details->links()}}
            </div>
        </div>
    </div>
@endsection
