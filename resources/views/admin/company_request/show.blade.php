@extends('admin.master')

@section('content')
    @include('admin.include.alert')

    @php
        $statusCls = ['pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger'][$companyRequest->status] ?? 'secondary';
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('admin.company-request.list') }}" class="text-muted text-decoration-none">
                <i class="ti ti-arrow-left me-1"></i> Back to list
            </a>
            <h4 class="mb-0 mt-2">
                {{ $companyRequest->company_name }}
                <span class="badge bg-label-{{ $statusCls }} ms-2">{{ ucfirst($companyRequest->status) }}</span>
            </h4>
            <small class="text-muted">Submitted {{ $companyRequest->created_at->format('d M Y H:i') }}</small>
        </div>
        @if($companyRequest->company_id && $companyRequest->company)
            <a href="{{ route('admin.company.edit', $companyRequest->company_id) }}" class="btn btn-outline-success">
                <i class="ti ti-building me-1"></i> View created Company
            </a>
        @endif
    </div>

    <div class="row">
        <div class="col-lg-8">
            {{-- Account info --}}
            <div class="card mb-4">
                <div class="card-header"><h6 class="mb-0">Account Information</h6></div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Company Name</dt><dd class="col-sm-8">{{ $companyRequest->company_name }}</dd>
                        <dt class="col-sm-4">Contact Person</dt><dd class="col-sm-8">{{ $companyRequest->contact_person_name }}</dd>
                        <dt class="col-sm-4">Designation</dt><dd class="col-sm-8">{{ $companyRequest->designation ?: '—' }}</dd>
                        <dt class="col-sm-4">Email</dt><dd class="col-sm-8">{{ $companyRequest->email }}</dd>
                        <dt class="col-sm-4">Mobile</dt><dd class="col-sm-8">{{ $companyRequest->mobile_number }}</dd>
                        <dt class="col-sm-4">WhatsApp</dt><dd class="col-sm-8">{{ $companyRequest->whatsapp_number ?: '—' }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header"><h6 class="mb-0">Company Information</h6></div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Company Type</dt><dd class="col-sm-8">{{ $companyRequest->company_type ?: '—' }}</dd>
                        <dt class="col-sm-4">Trade License #</dt><dd class="col-sm-8">{{ $companyRequest->trade_license_number ?: '—' }}</dd>
                        <dt class="col-sm-4">Trade License Expiry</dt><dd class="col-sm-8">{{ $companyRequest->trade_license_expiry?->format('d M Y') ?: '—' }}</dd>
                        <dt class="col-sm-4">TIN Number</dt><dd class="col-sm-8">{{ $companyRequest->tin_number ?: '—' }}</dd>
                        <dt class="col-sm-4">VAT Number</dt><dd class="col-sm-8">{{ $companyRequest->vat_number ?: '—' }}</dd>
                        <dt class="col-sm-4">Website</dt><dd class="col-sm-8">
                            @if($companyRequest->company_website)
                                <a href="{{ $companyRequest->company_website }}" target="_blank" rel="noopener">{{ $companyRequest->company_website }}</a>
                            @else — @endif
                        </dd>
                        <dt class="col-sm-4">Years in Business</dt><dd class="col-sm-8">{{ $companyRequest->years_in_business ?: '—' }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header"><h6 class="mb-0">Company Address</h6></div>
                <div class="card-body">
                    <p class="mb-2">{{ $companyRequest->office_address ?: '—' }}</p>
                    <small class="text-muted">
                        {{ implode(', ', array_filter([$companyRequest->city, $companyRequest->district, $companyRequest->country, $companyRequest->postal_code])) ?: '—' }}
                    </small>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header"><h6 class="mb-0">Property Listing Intent</h6></div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Property Category</dt><dd class="col-sm-8">{{ $companyRequest->property_category ?: '—' }}</dd>
                        <dt class="col-sm-4">Number of Properties</dt><dd class="col-sm-8">{{ $companyRequest->number_of_properties ?: '—' }}</dd>
                        <dt class="col-sm-4">Service Required</dt><dd class="col-sm-8"><span class="badge bg-label-info">{{ $companyRequest->service_required ?: '—' }}</span></dd>
                    </dl>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header"><h6 class="mb-0">Uploaded Documents</h6></div>
                <div class="card-body">
                    <div class="row g-3">
                        @php
                            $docs = [
                                'trade_license_copy'        => 'Trade License Copy',
                                'company_logo'              => 'Company Logo',
                                'national_id_passport'      => 'National ID / Passport',
                                'tin_certificate'           => 'TIN Certificate',
                                'incorporation_certificate' => 'Incorporation Certificate',
                                'utility_bill'              => 'Utility Bill',
                            ];
                        @endphp
                        @foreach($docs as $field => $label)
                            <div class="col-md-6">
                                <div class="border rounded p-3 d-flex align-items-center justify-content-between">
                                    <div>
                                        <strong>{{ $label }}</strong>
                                        @if($companyRequest->$field)
                                            <br><small class="text-muted">{{ basename($companyRequest->$field) }}</small>
                                        @else
                                            <br><small class="text-muted">Not provided</small>
                                        @endif
                                    </div>
                                    @if($companyRequest->$field)
                                        <a href="{{ asset($companyRequest->$field) }}" target="_blank" class="btn btn-sm btn-label-primary">
                                            <i class="ti ti-download me-1"></i> Open
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Right rail: review actions --}}
        <div class="col-lg-4">
            @if($companyRequest->status === 'pending')
                <div class="card mb-4">
                    <div class="card-header"><h6 class="mb-0 text-success"><i class="ti ti-check me-1"></i> Approve &amp; Create Company</h6></div>
                    <div class="card-body">
                        <form action="{{ route('admin.company-request.approve', $companyRequest->id) }}" method="POST">
                            @csrf
                            <p class="small text-muted">
                                Approving will create a new Company from this request. After approval, set up the company's
                                user login in the User section &mdash; credentials are not auto-generated here.
                            </p>
                            <div class="mb-3">
                                <label class="form-label">Company Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $companyRequest->company_name) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $companyRequest->email) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $companyRequest->mobile_number) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" rows="2" class="form-control">{{ old('address', $companyRequest->office_address) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Admin Notes</label>
                                <textarea name="notes" rows="2" class="form-control" placeholder="Optional notes for this approval"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="ti ti-check me-1"></i> Approve Request
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header"><h6 class="mb-0 text-danger"><i class="ti ti-x me-1"></i> Reject</h6></div>
                    <div class="card-body">
                        <form action="{{ route('admin.company-request.reject', $companyRequest->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Reason / Notes</label>
                                <textarea name="notes" rows="3" class="form-control" placeholder="Visible only to admins"></textarea>
                            </div>
                            <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('Reject this request?');">
                                Reject Request
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="card mb-4">
                    <div class="card-body">
                        <h6>Review Outcome</h6>
                        <p class="mb-1">
                            <span class="badge bg-label-{{ $statusCls }}">{{ ucfirst($companyRequest->status) }}</span>
                            on {{ optional($companyRequest->reviewed_at)->format('d M Y H:i') ?: '—' }}
                        </p>
                        @if($companyRequest->admin_notes)
                            <hr>
                            <small class="text-muted">Admin notes:</small>
                            <p class="mb-0">{{ $companyRequest->admin_notes }}</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
