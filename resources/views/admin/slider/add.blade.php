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
                    <h5 class="mb-0">User Create</h5>
                </div>
                <div class="col-xxl">
                    <div class="card-body">
                        <form action="{{route('admin.slider.add.post')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-8">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label"
                                               for="basic-default-name">Slider Title</label>
                                        <div class="col-sm-9 ">
                                            <input type="text" class="form-control" name="title" placeholder="Enter slider title" value="{{ old('title') }}" />
                                        </div>
                                        @if($errors->has('title'))
                                            <div class="error col-sm-10">{{ $errors->first('title') }}</div>
                                        @endif
                                    </div>

                                    <div class="row mb-3">
                                        <label for="" class="col-sm-3 col-form-label">Slider Image <span class="text-gray">(3360×2240 px)</span></label>
                                        <div class="col-sm-9">
                                            <input type="file" class="form-control" name="image" />
                                        </div>
                                        @if($errors->has('file'))
                                            <div class="error col-sm-10">{{ $errors->first('file') }}</div>
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
