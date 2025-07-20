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
                    <h5 class="mb-0">Review Create</h5>
                </div>
                <div class="col-xxl">
                    <div class="card-body">
                        <form action="{{route('admin.testimonial.add.post')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-8">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label"
                                               for="basic-default-name">Client Name</label>
                                        <div class="col-sm-9 ">
                                            <input type="text" class="form-control" name="name"
                                                   placeholder="Enter slider title" value="{{ old('name') }}"/>
                                        </div>
                                        @if($errors->has('name'))
                                            <div class="error col-sm-10">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label"
                                               for="basic-default-name">Client Designation</label>
                                        <div class="col-sm-9 ">
                                            <input type="text" class="form-control" name="designation"
                                                   placeholder="Enter Designation" value="{{ old('designation') }}"/>
                                        </div>
                                        @if($errors->has('designation'))
                                            <div class="error col-sm-10">{{ $errors->first('designation') }}</div>
                                        @endif
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label"
                                               for="basic-default-name">Review</label>
                                        <div class="col-sm-9 ">
                                            <textarea class="form-control" name="review"
                                                      placeholder="Enter Review">{{ old('review') }}</textarea>
                                        </div>
                                        @if($errors->has('review'))
                                            <div class="error col-sm-10">{{ $errors->first('review') }}</div>
                                        @endif
                                    </div>
                                    <div class="row mb-3">
                                        <label for="" class="col-sm-3 col-form-label">Client Image</label>
                                        <div class="col-sm-9">
                                            <input type="file" class="form-control" name="image"/>
                                        </div>
                                        @if($errors->has('file'))
                                            <div class="error col-sm-10">{{ $errors->first('file') }}</div>
                                        @endif
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label"
                                               for="basic-default-name">Social Link</label>
                                        <div class="col-sm-9 ">
                                            <input class="form-control" name="s_link" type="text"
                                                   placeholder="Enter social link">{{ old('s_link') }}</input>
                                        </div>
                                        @if($errors->has('s_link'))
                                            <div class="error col-sm-10">{{ $errors->first('s_link') }}</div>
                                        @endif
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label" for="multicol-country">Status</label>
                                        <div class="col-sm-9">
                                            <select id="multicol-country" name="status" class="select form-select"
                                                    data-allow-clear="true">
                                                <option value="">Select</option>
                                                <option value="active">Active</option>
                                                <option value="inactive">InActive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="w-100 text-center">
                                        <button type="submit" class="btn btn-primary w-100">Save</button>
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
