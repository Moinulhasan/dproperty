@extends('admin.master')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Inquiry Details</h5>
                        <a href="{{ route('admin.contact-inquiry.list') }}" class="btn btn-sm btn-label-secondary">
                            <i class="ti ti-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body pt-4">
                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small text-uppercase">From</label>
                        <h4 class="mb-0">{{ $contactInquiry->name }}</h4>
                        <p class="text-muted mb-0">{{ $contactInquiry->email }} | {{ $contactInquiry->phone ?? 'No phone provided' }}</p>
                    </div>
                    <hr>
                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small text-uppercase">Message</label>
                        <div class="p-3 bg-light rounded" style="white-space: pre-wrap;">{{ $contactInquiry->message }}</div>
                    </div>
                    <div class="text-muted small">
                        Received on {{ $contactInquiry->created_at->format('d M, Y - h:i A') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header border-bottom">
                    <h6 class="mb-0">Manage Status</h6>
                </div>
                <div class="card-body pt-3">
                    <form action="{{ route('admin.contact-inquiry.update-status', $contactInquiry) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="pending" {{ $contactInquiry->status == 'pending' ? 'selected' : '' }}>Unread (Pending)</option>
                                <option value="read" {{ $contactInquiry->status == 'read' ? 'selected' : '' }}>Read</option>
                                <option value="archived" {{ $contactInquiry->status == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Status</button>
                    </form>
                    <hr>
                    <a href="mailto:{{ $contactInquiry->email }}?subject=Reply to your inquiry at DProperty" class="btn btn-label-primary w-100">
                        <i class="ti ti-mail me-1"></i> Reply via Email
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
