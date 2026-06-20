@extends('admin.master')

@section('content')
    @include('admin.include.alert')

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.company-request.list') }}" method="GET" class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">Search</label>
                    <input type="text" name="q" class="form-control" placeholder="Company name, email or mobile..." value="{{ request('q') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All</option>
                        @foreach(['pending', 'approved', 'rejected'] as $s)
                            <option value="{{ $s }}" @selected(request('status') == $s)>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100 me-2"><i class="ti ti-search me-1"></i> Filter</button>
                    <a href="{{ route('admin.company-request.list') }}" class="btn btn-label-secondary w-100"><i class="ti ti-refresh me-1"></i> Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Company Requests</h5>
            <small class="text-muted">Submitted via the public <code>/company-register</code> page.</small>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Company</th>
                        <th>Contact</th>
                        <th>Service</th>
                        <th>Submitted</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($requests as $r)
                        <tr>
                            <td>
                                <strong>{{ $r->company_name }}</strong>
                                <br><small class="text-muted">{{ $r->company_type ?? '—' }}</small>
                            </td>
                            <td>
                                {{ $r->contact_person_name }}
                                <br><small class="text-muted">{{ $r->email }} · {{ $r->mobile_number }}</small>
                            </td>
                            <td>
                                <span class="badge bg-label-info">{{ $r->service_required ?? '—' }}</span>
                                <br><small class="text-muted">{{ $r->property_category ?? '' }}</small>
                            </td>
                            <td>{{ $r->created_at->format('d M Y') }}</td>
                            <td>
                                @php
                                    $cls = ['pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger'][$r->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-label-{{ $cls }}">{{ ucfirst($r->status) }}</span>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('admin.company-request.show', $r->id) }}" class="btn btn-sm btn-icon btn-primary me-2" title="Review">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.company-request.delete', $r->id) }}" class="btn btn-sm btn-icon btn-danger" title="Delete" onclick="return confirm('Delete this request?')">
                                        <i class="ti ti-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No company requests yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $requests->links() }}
        </div>
    </div>
@endsection
