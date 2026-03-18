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
                    <h5 class="mb-0">Add Location</h5>
                </div>
                <div class="col-xxl">
                    <div class="card-body">
                        <form action="{{route('admin.location.add.post')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-8">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label" for="location-name">Location Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="location-name" name="name" placeholder="Enter location name" value="{{ old('name') }}" required />
                                        </div>
                                        @if($errors->has('name'))
                                            <div class="error col-sm-10">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>

                                    <div class="row mb-3">
                                        <label for="location-image" class="col-sm-3 col-form-label">Location Image</label>
                                        <div class="col-sm-9">
                                            <input type="file" class="form-control" id="location-image" name="image" accept="image/*" />
                                        </div>
                                        @if($errors->has('image'))
                                            <div class="error col-sm-10">{{ $errors->first('image') }}</div>
                                        @endif
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label" for="location-status">Status</label>
                                        <div class="col-sm-9">
                                            <select id="location-status" name="status" class="select form-select" data-allow-clear="true">
                                                <option value="">Select</option>
                                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="w-100 text-center">
                                        <button type="submit" class="btn btn-primary w-100">Save Location</button>
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
