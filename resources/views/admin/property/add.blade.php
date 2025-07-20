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
                        <form action="{{route('admin.property.add.post')}}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-8">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label" for="multicol-country">Property
                                            Link</label>
                                        <div class="col-sm-9">
                                            <select id="multicol-country" name="type" class="select form-select"
                                                    data-allow-clear="true">
                                                <option value="">Select</option>
                                                <option value="fb">Facebook</option>
                                                <option value="yu">Youtube</option>
                                            </select>
                                            @if($errors->has('type'))
                                                <div class="error col-sm-10">{{ $errors->first('type') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label"
                                               for="basic-default-name">Property Link</label>
                                        <div class="col-sm-9 ">
                                            <input type="text" class="form-control" name="link"
                                                   placeholder="Enter property link" value="{{ old('link') }}"/>
                                        </div>
                                        @if($errors->has('link'))
                                            <div class="error col-sm-10">{{ $errors->first('link') }}</div>
                                        @endif
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label"
                                               for="basic-default-name">Description</label>
                                        <div class="col-sm-9 ">
                                            <textarea class="form-control" name="description"
                                                      placeholder="Enter Review">{{ old('description') }}</textarea>
                                        </div>
                                        @if($errors->has('description'))
                                            <div class="error col-sm-10">{{ $errors->first('description') }}</div>
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
