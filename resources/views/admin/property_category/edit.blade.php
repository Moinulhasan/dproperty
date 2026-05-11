@extends('admin.master')

@section('content')
    @if(session()->get('success'))
        <div class="alert alert-success" role="alert">{{session()->get('success')}}</div>
    @endif
    @if(session()->get('errors'))
        <div class="alert alert-danger" role="alert">{{session()->get('errors')->first()}}</div>
    @endif
    <div class="row">
        <div class="col-xl">
            <div class="card mb-12">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Property Category</h5>
                </div>
                <div class="col-xxl">
                    <div class="card-body">
                        <form action="{{route('admin.property_category.edit.post', $propertyCategory)}}" method="POST">
                            @csrf
                            @method('post')
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-8">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label" for="category-name">Category Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="category-name" name="name" placeholder="Enter category name" value="{{ old('name', $propertyCategory->name) }}" required />
                                        </div>
                                        @if($errors->has('name'))
                                            <div class="error col-sm-10">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label" for="parent-id">Parent Category</label>
                                        <div class="col-sm-9">
                                            <select id="parent-id" name="parent_id" class="select form-select" data-allow-clear="true">
                                                <option value="">None (Top Level)</option>
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat->id }}" {{ old('parent_id', $propertyCategory->parent_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label" for="category-status">Status</label>
                                        <div class="col-sm-9">
                                            <select id="category-status" name="status" class="select form-select" data-allow-clear="true">
                                                <option value="active" {{ $propertyCategory->status == 1 ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ $propertyCategory->status == 0 ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="w-100 text-center">
                                        <button type="submit" class="btn btn-primary w-100">Update Category</button>
                                    </div>
                                </div>
                                <div class="col-2"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
