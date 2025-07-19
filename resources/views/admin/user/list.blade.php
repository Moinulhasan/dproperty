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
            <div class="d-flex justify-content-between  row pb-2 gap-3 gap-md-0 w-100">
                <div class="col-md-6">
                    <h5>Filter Item</h5>
                </div>
                <div class="col-md-6 user_role" style="text-align: right">
                    <a href="{{route('admin.user.add')}}" class="btn btn-label-primary">Add User</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-datatable table-responsive">
                <table class="datatables-users table" id="slotList">
                    <thead class="border-top">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created at</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($users))
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{\Illuminate\Support\Carbon::parse($user->created_at)->diffForHumans()}}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{route('admin.user.edit',$user)}}"
                                           class="btn btn-sm btn-icon btn-primary me-2" title="Edit User">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <a href="{{route('admin.user.delete',$user)}}"
                                           class="btn btn-sm btn-icon btn-primary me-2">
                                            <i class="ti ti-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{$users->links()}}
            </div>
        </div>
    </div>
@endsection
