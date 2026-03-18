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
                    <h5 class="mb-0">Edit Property Detail Field</h5>
                </div>
                <div class="col-xxl">
                    <div class="card-body">
                        <form action="{{route('admin.property-detail.edit.post', $propertyDetail)}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-1"></div>
                                <div class="col-10">
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label" for="detail-name">Field Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="detail-name" name="name" placeholder="e.g. Bedrooms" value="{{ old('name', $propertyDetail->name) }}" required />
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label" for="detail-icon">Icon Class</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="detail-icon" name="icon" placeholder="e.g. fas fa-bed" value="{{ old('icon', $propertyDetail->icon) }}" />
                                                <span class="input-group-text" id="icon-preview">
                                                    <i class="{{ old('icon', $propertyDetail->icon ?: 'fas fa-icons') }}"></i>
                                                </span>
                                            </div>
                                            <small class="text-muted">Use Font Awesome icon classes. <a href="https://fontawesome.com/icons" target="_blank">Browse icons →</a></small>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label" for="detail-input-type">Input Type</label>
                                        <div class="col-sm-9">
                                            <select id="detail-input-type" name="input_type" class="form-select" required>
                                                <option value="text" {{ old('input_type', $propertyDetail->input_type) == 'text' ? 'selected' : '' }}>Text</option>
                                                <option value="number" {{ old('input_type', $propertyDetail->input_type) == 'number' ? 'selected' : '' }}>Number</option>
                                                <option value="select" {{ old('input_type', $propertyDetail->input_type) == 'select' ? 'selected' : '' }}>Dropdown (Select)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3" id="options-row" style="{{ old('input_type', $propertyDetail->input_type) == 'select' ? '' : 'display:none' }}">
                                        <label class="col-sm-3 col-form-label" for="detail-options">Dropdown Options</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="detail-options" name="options" placeholder="Option1, Option2, Option3" value="{{ old('options', $propertyDetail->options ? implode(', ', $propertyDetail->options) : '') }}" />
                                            <small class="text-muted">Comma-separated list of options</small>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label" for="detail-sort">Sort Order</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" id="detail-sort" name="sort_order" value="{{ old('sort_order', $propertyDetail->sort_order) }}" />
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label" for="detail-status">Status</label>
                                        <div class="col-sm-9">
                                            <select id="detail-status" name="status" class="form-select">
                                                <option value="active" {{ $propertyDetail->status == 1 ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ $propertyDetail->status == 0 ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="w-100 text-center">
                                        <button type="submit" class="btn btn-primary w-100">Update Detail Field</button>
                                    </div>
                                </div>
                                <div class="col-1"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#detail-input-type').on('change', function() {
            if ($(this).val() === 'select') {
                $('#options-row').show();
            } else {
                $('#options-row').hide();
            }
        });

        $('#detail-icon').on('input', function() {
            var iconClass = $(this).val() || 'fas fa-icons';
            $('#icon-preview i').attr('class', iconClass);
        });
    });
</script>
@endsection
