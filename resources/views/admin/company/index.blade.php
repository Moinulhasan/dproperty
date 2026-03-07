@extends('admin.master')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Company List</h5>
            <a href="{{ route('admin.company.add') }}" class="btn btn-primary">Add Company</a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($companies as $company)
                        <tr>
                            <td>
                                @if($company->logo)
                                    <img src="{{ asset($company->logo) }}" alt="{{ $company->name }}" width="50">
                                @else
                                    No Logo
                                @endif
                            </td>
                            <td>{{ $company->name }}</td>
                            <td>{{ $company->email }}</td>
                            <td>{{ $company->phone }}</td>
                            <td>
                                <span class="badge bg-label-{{ $company->status == 'active' ? 'success' : 'danger' }}">
                                    {{ ucfirst($company->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.company.edit', $company->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <a href="{{ route('admin.company.delete', $company->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $companies->links() }}
        </div>
    </div>
@endsection
