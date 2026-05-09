@extends('admin.master')

@section('content')
    @if(session()->get('success'))
        <div class="alert alert-success" role="alert">{{session()->get('success')}}</div>
    @endif
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Property Request Details</h5>
                        <a href="{{ route('admin.property-request.list') }}" class="btn btn-sm btn-label-secondary">
                            <i class="ti ti-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body pt-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted small text-uppercase">Want To</label>
                                <div>
                                    @if($propertyRequest->want_to == 'Sale')
                                        <span class="badge bg-danger fs-6 px-3 py-2">Sale</span>
                                    @else
                                        <span class="badge bg-primary fs-6 px-3 py-2">Rent</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted small text-uppercase">Status</label>
                                <div>
                                    @switch($propertyRequest->status)
                                        @case('pending')
                                            <span class="badge bg-warning fs-6 px-3 py-2">Pending</span>
                                            @break
                                        @case('reviewed')
                                            <span class="badge bg-info fs-6 px-3 py-2">Reviewed</span>
                                            @break
                                        @case('approved')
                                            <span class="badge bg-success fs-6 px-3 py-2">Approved</span>
                                            @break
                                        @case('rejected')
                                            <span class="badge bg-danger fs-6 px-3 py-2">Rejected</span>
                                            @break
                                    @endswitch
                                </div>
                            </div>
                        </div>

                        <div class="col-12"><hr class="my-0"></div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small text-uppercase">Property Type</label>
                            <p class="mb-0">{{ $propertyRequest->property_type ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small text-uppercase">Property Category</label>
                            <p class="mb-0">{{ $propertyRequest->property_category ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small text-uppercase">Furnished Type</label>
                            <p class="mb-0">{{ $propertyRequest->furnished_type ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small text-uppercase">Facing</label>
                            <p class="mb-0">{{ $propertyRequest->facing ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small text-uppercase">SFT (Square Feet)</label>
                            <p class="mb-0">{{ $propertyRequest->sft ? number_format($propertyRequest->sft) . ' SFT' : '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small text-uppercase">Price</label>
                            <p class="mb-0 fw-bold text-success">{{ $propertyRequest->price ? '৳ ' . number_format($propertyRequest->price, 0) : '-' }}</p>
                        </div>

                        <div class="col-12"><hr class="my-0"></div>

                        <div class="col-12">
                            <label class="form-label fw-bold text-muted small text-uppercase">Address</label>
                            <p class="mb-0">{{ $propertyRequest->address ?? '-' }}</p>
                        </div>

                        @if($propertyRequest->message)
                            <div class="col-12">
                                <label class="form-label fw-bold text-muted small text-uppercase">Message</label>
                                <div class="bg-light p-3 rounded">
                                    {{ $propertyRequest->message }}
                                </div>
                            </div>
                        @endif

                        <div class="col-12"><hr class="my-0"></div>

                        <div class="col-12">
                            <label class="form-label fw-bold text-muted small text-uppercase">Submitted On</label>
                            <p class="mb-0">{{ $propertyRequest->created_at->format('d M, Y - h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- Contact Info Card --}}
            <div class="card mb-4">
                <div class="card-header border-bottom">
                    <h6 class="mb-0"><i class="ti ti-user me-2"></i>Contact Information</h6>
                </div>
                <div class="card-body pt-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small text-uppercase">Name</label>
                        <p class="mb-0 fw-bold">{{ $propertyRequest->name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small text-uppercase">Phone</label>
                        <p class="mb-0">
                            <a href="tel:{{ $propertyRequest->phone }}" class="text-primary">
                                <i class="ti ti-phone me-1"></i>{{ $propertyRequest->phone }}
                            </a>
                        </p>
                    </div>
                    @if($propertyRequest->email)
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Email</label>
                            <p class="mb-0">
                                <a href="mailto:{{ $propertyRequest->email }}" class="text-primary">
                                    <i class="ti ti-mail me-1"></i>{{ $propertyRequest->email }}
                                </a>
                            </p>
                        </div>
                    @endif
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $propertyRequest->phone) }}" target="_blank" class="btn btn-success w-100 mt-2">
                        <i class="ti ti-brand-whatsapp me-1"></i> WhatsApp
                    </a>
                </div>
            </div>

            {{-- Update Status Card --}}
            <div class="card">
                <div class="card-header border-bottom">
                    <h6 class="mb-0"><i class="ti ti-settings me-2"></i>Update Status</h6>
                </div>
                <div class="card-body pt-3">
                    <form action="{{ route('admin.property-request.update-status', $propertyRequest) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="pending" {{ $propertyRequest->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="reviewed" {{ $propertyRequest->status == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                <option value="approved" {{ $propertyRequest->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $propertyRequest->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Admin Notes</label>
                            <textarea name="admin_notes" class="form-control" rows="3" placeholder="Internal notes...">{{ $propertyRequest->admin_notes }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ti ti-check me-1"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
