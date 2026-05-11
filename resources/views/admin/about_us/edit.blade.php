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
                    <h5 class="mb-0">Edit About Us Section</h5>
                </div>
                <div class="col-xxl">
                    <div class="card-body">
                        <form action="{{route('admin.about_us.edit.post', $aboutUs)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-8">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label" for="title">Title</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" value="{{ old('title', $aboutUs->title) }}" required />
                                        </div>
                                        @if($errors->has('title'))
                                            <div class="error col-sm-10">{{ $errors->first('title') }}</div>
                                        @endif
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label" for="description">Description</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="description" name="description" rows="5" placeholder="Enter description" required>{{ old('description', $aboutUs->description) }}</textarea>
                                        </div>
                                        @if($errors->has('description'))
                                            <div class="error col-sm-10">{{ $errors->first('description') }}</div>
                                        @endif
                                    </div>

                                    <div class="row mb-3">
                                        <label for="image" class="col-sm-3 col-form-label">Image</label>
                                        <div class="col-sm-9">
                                            @if($aboutUs->image)
                                                <div class="mb-2">
                                                    <img src="{{ asset($aboutUs->image) }}" alt="{{ $aboutUs->title }}" style="width: 200px; height: 120px; object-fit: cover; border-radius: 8px;">
                                                </div>
                                            @endif
                                            <input type="file" class="form-control" id="image" name="image" accept="image/*" />
                                            <small class="text-muted">Leave blank to keep current image</small>
                                        </div>
                                        @if($errors->has('image'))
                                            <div class="error col-sm-10">{{ $errors->first('image') }}</div>
                                        @endif
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label" for="status">Status</label>
                                        <div class="col-sm-9">
                                            <select id="status" name="status" class="select form-select" data-allow-clear="true">
                                                <option value="active" {{ $aboutUs->status == 1 ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ $aboutUs->status == 0 ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="w-100 text-center">
                                        <button type="submit" class="btn btn-primary w-100">Update Section</button>
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
