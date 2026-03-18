@extends('admin.master')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Article List</h5>
        <a href="{{ route('admin.article.add') }}" class="btn btn-primary">Add New Article</a>
    </div>
    <div class="table-responsive text-nowrap">
        @include('admin.include.alert')
        <table class="table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Views</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($articles as $article)
                <tr>
                    <td>
                        @if($article->image)
                            <img src="{{ asset($article->image) }}" alt="Article" class="rounded" width="50">
                        @else
                            <span class="badge bg-label-secondary">No Image</span>
                        @endif
                    </td>
                    <td><strong>{{ $article->title }}</strong></td>
                    <td>
                        <span class="badge bg-label-{{ $article->status ? 'success' : 'danger' }}">
                            {{ $article->status ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>{{ $article->views }}</td>
                    <td>{{ $article->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('admin.article.edit', $article->id) }}">
                                    <i class="ti ti-pencil me-1"></i> Edit
                                </a>
                                <a class="dropdown-item text-danger" href="{{ route('admin.article.delete', $article->id) }}" onclick="return confirm('Are you sure?')">
                                    <i class="ti ti-trash me-1"></i> Delete
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No articles found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $articles->links() }}
    </div>
</div>
@endsection
