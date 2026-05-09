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
                    <h5>Property Requests</h5>
                </div>
                <div class="col-md-6 text-end">
                    <span class="badge bg-label-warning me-2">{{ $requests->where('status', 'pending')->count() }} Pending</span>
                    <span class="badge bg-label-info me-2">{{ $requests->where('status', 'reviewed')->count() }} Reviewed</span>
                    <span class="badge bg-label-success me-2">{{ $requests->where('status', 'approved')->count() }} Approved</span>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-datatable table-responsive">
                <table class="datatables-sliders table" id="propertyRequestList">
                    <thead class="border-top">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Want To</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($requests as $req)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $req->name }}</strong>
                                @if($req->email)
                                    <br><small class="text-muted">{{ $req->email }}</small>
                                @endif
                            </td>
                            <td>{{ $req->phone }}</td>
                            <td>
                                @if($req->want_to == 'Sale')
                                    <span class="badge bg-label-danger">Sale</span>
                                @else
                                    <span class="badge bg-label-primary">Rent</span>
                                @endif
                            </td>
                            <td>{{ $req->property_type }}</td>
                            <td>{{ $req->property_category }}</td>
                            <td>{{ $req->price ? '৳ ' . number_format($req->price, 0) : '-' }}</td>
                            <td>
                                @switch($req->status)
                                    @case('pending')
                                        <span class="badge bg-label-warning">Pending</span>
                                        @break
                                    @case('reviewed')
                                        <span class="badge bg-label-info">Reviewed</span>
                                        @break
                                    @case('approved')
                                        <span class="badge bg-label-success">Approved</span>
                                        @break
                                    @case('rejected')
                                        <span class="badge bg-label-danger">Rejected</span>
                                        @break
                                @endswitch
                            </td>
                            <td>{{ $req->created_at->format('d M, Y') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('admin.property-request.show', $req) }}"
                                       class="btn btn-sm btn-icon btn-info me-2" title="View Details">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.property-request.delete', $req) }}"
                                       class="btn btn-sm btn-icon btn-danger" title="Delete"
                                       onclick="return confirm('Are you sure you want to delete this request?')">
                                        <i class="ti ti-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4 text-muted">No property requests yet.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
