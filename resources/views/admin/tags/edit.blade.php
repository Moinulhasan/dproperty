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
                    <h5 class="mb-0">Service Create</h5>
                </div>
                <div class="col-xxl">
                    <div class="card-body">
                        <form action="{{route('admin.tag.edit.post',$tag)}}" method="POST">
                            @csrf
                            @method('post')
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-8">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label" for="multicol-country">Service
                                            Title</label>
                                        <div class="col-sm-9">
                                            <select id="multicol-country" name="service_type" class="select form-select"
                                                    data-allow-clear="true">
                                                <option value="">Select</option>
                                                <option
                                                    value="services" {{$tag->service_type == 'services'?'selected':''}}>
                                                    Services
                                                </option>
                                                <option
                                                    value="featured_project" {{$tag->service_type == 'featured_project'?'selected':''}}>
                                                    Featured Project
                                                </option>
                                                <option
                                                    value="contact" {{$tag->service_type == 'contact'?'selected':''}}>
                                                    Contact
                                                </option>
                                                <option
                                                    value="why_choose_us" {{$tag->service_type == 'why_choose_us'?'selected':''}}>
                                                    Why Choose Us
                                                </option>
                                            </select>
                                        </div>
                                        @if($errors->has('service_type'))
                                            <div class="error col-sm-10">{{ $errors->first('service_type') }}</div>
                                        @endif
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label"
                                               for="basic-default-name">Service Description</label>
                                        <div class="col-sm-9 ">
                                            <textarea class="form-control" name="tag_line"
                                                      placeholder="Enter service description">{{ $tag->tag_line }}</textarea>
                                        </div>
                                        @if($errors->has('tag_line'))
                                            <div class="error col-sm-10">{{ $errors->first('tag_line') }}</div>
                                        @endif
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label" for="multicol-country">Status</label>
                                        <div class="col-sm-9">
                                            <select id="multicol-country" name="status" class="select form-select"
                                                    data-allow-clear="true">
                                                <option value="">Select</option>
                                                <option value="active" {{$tag->status == 1?'selected':''}}>Active
                                                </option>
                                                <option value="inactive" {{$tag->status == 0?'selected':''}}>InActive</option>
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
