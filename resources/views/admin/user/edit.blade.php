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
                        <form action="{{route('admin.user.update',$user)}}" method="POST">
                            @csrf
                            @method('post')
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-8">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label"
                                               for="basic-default-name">User Name</label>
                                        <div class="col-sm-9 ">
                                            <input type="text" class="form-control" name="name"
                                                   placeholder="Enter user name" value="{{ $user->name }}"/>
                                        </div>
                                        @if($errors->has('name'))
                                            <div class="error col-sm-10">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>

                                    <div class="row mb-3">
                                        <label for="" class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" name="email"
                                                   placeholder="Enter email" value="{{ $user->email }}"/>
                                        </div>
                                        @if($errors->has('email'))
                                            <div class="error col-sm-10">{{ $errors->first('email') }}</div>
                                        @endif
                                    </div>
                                    <div class="row mb-3">
                                        <label for="" class="col-sm-3 col-form-label">Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" name="password"
                                                   placeholder="Enter Password" value="{{ old('password') }}"/>
                                        </div>
                                        @if($errors->has('password'))
                                            <div class="error col-sm-10">{{ $errors->first('password') }}</div>
                                        @endif
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
