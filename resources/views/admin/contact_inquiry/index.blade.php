@extends('admin.master')

@section('content')
    @if(session()->get('success'))
        <div class="alert alert-success" role="alert">{{session()->get('success')}}</div>
    @endif
    <div class="card">
        <div class="card-header border-bottom">
            <div class="d-flex justify-content-between row pb-2 gap-3 gap-md-0 w-100">
                <div class="col-md-6">
                    <h5>Contact Inquiries</h5>
                </div>
                <div class="col-md-6 text-end">
                    <span class="badge bg-label-warning me-2">{{ $inquiries->where('status', 'pending')->count() }} Unread</span>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-datatable table-responsive">
                <table class="datatables-sliders table" id="contactInquiryList">
                    <thead class="border-top">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($inquiries as $inq)
                        <tr class="{{ $inq->status == 'pending' ? 'fw-bold' : '' }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $inq->name }}</td>
                            <td>{{ $inq->email }}</td>
                            <td>{{ $inq->phone ?? '-' }}</td>
                            <td>{{ Str::limit($inq->message, 50) }}</td>
                            <td>
                                @switch($inq->status)
                                    @case('pending')
                                        <span class="badge bg-label-warning">Unread</span>
                                        @break
                                    @case('read')
                                        <span class="badge bg-label-info">Read</span>
                                        @break
                                    @case('archived')
                                        <span class="badge bg-label-secondary">Archived</span>
                                        @break
                                @endswitch
                            </td>
                            <td>{{ $inq->created_at->format('d M, Y') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('admin.contact-inquiry.show', $inq) }}"
                                       class="btn btn-sm btn-icon btn-info me-2" title="View Details">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.contact-inquiry.delete', $inq) }}"
                                       class="btn btn-sm btn-icon btn-danger" title="Delete"
                                       onclick="return confirm('Are you sure you want to delete this inquiry?')">
                                        <i class="ti ti-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No inquiries yet.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
