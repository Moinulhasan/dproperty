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
                        <form action="#" method="POST">
                            @csrf
                            @method('post')
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-8">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label"
                                               for="basic-default-name">Campaign Name</label>
                                        <div class="col-sm-9 ">
                                            <input type="text" class="form-control" name="user_name" placeholder="Enter campaign name" value="{{ old('campaign_name') }}" />
                                        </div>
                                        @if($errors->has('user_name'))
                                            <div class="error col-sm-10">{{ $errors->first('user_name') }}</div>
                                        @endif
                                    </div>

                                    <div class="row mb-3">
                                        <label for="" class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" name="email" placeholder="Enter email" value="{{ old('email') }}" />
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
