@extends('admin.master')

@section('content')

    <div class="card">
        <div class="card-header border-bottom">
            <div class="d-flex justify-content-between  row pb-2 gap-3 gap-md-0 w-100">
                <div class="col-md-6">
                    <h5>Filter Item</h5>
                </div>
                <div class="col-md-6 user_role" style="text-align: right">
                    <a href="#" class="btn btn-label-primary">Add Slots</a>
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
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($users))
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{\Illuminate\Support\Carbon::parse($user->created_at)->diffForHumans()}}</td>
                                <td></td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
