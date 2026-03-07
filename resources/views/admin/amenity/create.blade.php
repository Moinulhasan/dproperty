@extends('admin.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Add New Amenity</h5>
                    <small class="text-muted float-end">Create property features</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.amenity.add.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="name">Amenity Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="e.g. Swimming Pool" value="{{ old('name') }}" required />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="icon">FontAwesome Icon Class</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-star"></i></span>
                                <input type="text" id="icon" name="icon" class="form-control @error('icon') is-invalid @enderror" placeholder="fas fa-swimmer" value="{{ old('icon') }}" />
                            </div>
                            <div class="form-text">Example: <code>fas fa-swimming-pool</code>, <code>fas fa-wifi</code>, <code>fas fa-dumbbell</code></div>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Create Amenity</button>
                        <a href="{{ route('admin.amenity.list') }}" class="btn btn-outline-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
