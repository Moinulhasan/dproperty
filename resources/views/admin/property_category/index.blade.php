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
                    <h5>Property Category List</h5>
                </div>
                <div class="col-md-6 user_role" style="text-align: right">
                    <a href="{{route('admin.property_category.add')}}" class="btn btn-label-primary">Add Category</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-datatable table-responsive">
                <table class="table" id="categoryList">
                    <thead class="border-top">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Parent Category</th>
                        <th>Status</th>
                        <th>Properties</th>
                        <th>Created at</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(count($categories))
                            @foreach($categories as $key => $category)
                                <tr>
                                    <td>{{ $categories->firstItem() + $key }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        @if($category->parent)
                                            <span class="badge bg-label-info">{{ $category->parent->name }}</span>
                                        @else
                                            <span class="badge bg-label-secondary">None</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($category->status == 1)
                                            <span class="badge bg-label-success">Active</span>
                                        @else
                                            <span class="badge bg-label-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-label-primary">{{ $category->properties()->count() }}</span>
                                    </td>
                                    <td>{{\Illuminate\Support\Carbon::parse($category->created_at)->diffForHumans()}}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{route('admin.property_category.edit', $category)}}" class="btn btn-sm btn-icon btn-primary me-2" title="Edit Category">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <a href="{{route('admin.property_category.delete', $category)}}" class="btn btn-sm btn-icon btn-danger" title="Delete Category" onclick="return confirm('Are you sure you want to delete this category?')">
                                                <i class="ti ti-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No categories found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{$categories->links()}}
            </div>
        </div>
    </div>
@endsection
