@extends('admin.master')

@section('content')
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Property: {{ $property->title }}</h5>
                </div>
                <div class="card-body">
                    @include('admin.include.alert')
                    <form action="{{ route('admin.property.edit.post', $property->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Basic Info -->
                        <div class="divider divider-primary">
                            <div class="divider-text">Basic Information</div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label" for="property-title">Property Title</label>
                                <input type="text" class="form-control" id="property-title" name="title" placeholder="Enter property title" value="{{ old('title', $property->title) }}" required>
                                @error('title')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="property-price">Price</label>
                                <input type="number" class="form-control" id="property-price" name="price" placeholder="Enter price" value="{{ old('price', $property->price) }}" required>
                                @error('price')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="property-category">Category</label>
                                <select class="form-select" id="property-category" name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="Residential" {{ old('category', $property->category) == 'Residential' ? 'selected' : '' }}>Residential</option>
                                    <option value="Commercial" {{ old('category', $property->category) == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="property-type">Property Type</label>
                                <select class="form-select" id="property-type" name="property_type" required>
                                    <option value="">Select Type</option>
                                    <option value="Apartment" {{ old('property_type', $property->property_type) == 'Apartment' ? 'selected' : '' }}>Apartment</option>
                                    <option value="House" {{ old('property_type', $property->property_type) == 'House' ? 'selected' : '' }}>House</option>
                                    <option value="Land" {{ old('property_type', $property->property_type) == 'Land' ? 'selected' : '' }}>Land</option>
                                    <option value="Office" {{ old('property_type', $property->property_type) == 'Office' ? 'selected' : '' }}>Office</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="property-status">Property Status</label>
                                <select class="form-select" id="property-status" name="property_status" required>
                                    <option value="">Select Status</option>
                                    <option value="Buy" {{ old('property_status', $property->property_status) == 'Buy' ? 'selected' : '' }}>Buy</option>
                                    <option value="Rent" {{ old('property_status', $property->property_status) == 'Rent' ? 'selected' : '' }}>Rent</option>
                                    <option value="Sell" {{ old('property_status', $property->property_status) == 'Sell' ? 'selected' : '' }}>Sell</option>
                                </select>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="divider divider-primary">
                            <div class="divider-text">Property Description</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="property-description">Description</label>
                            <textarea class="form-control" id="property-description" name="description" placeholder="Enter detailed property description">{{ old('description', $property->description) }}</textarea>
                            @error('description')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                        </div>

                        <!-- Location -->
                        <div class="divider divider-primary">
                            <div class="divider-text">Location (Hierarchy)</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="loc-location">Location</label>
                                <select class="form-select" id="loc-location" name="location_id">
                                    <option value="">Select Location</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}" {{ old('location_id', $property->location_id) == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="loc-sub-route">Sub Route</label>
                                <input type="text" class="form-control" id="loc-sub-route" name="sub_route" value="{{ old('sub_route', $property->sub_route) }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="loc-road">Road</label>
                                <input type="text" class="form-control" id="loc-road" name="road" value="{{ old('road', $property->road) }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="loc-lane">Lane</label>
                                <input type="text" class="form-control" id="loc-lane" name="lane" value="{{ old('lane', $property->lane) }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="map-link">Google Map Link (Link/Iframe)</label>
                            <input type="text" class="form-control" id="map-link" name="map_link" value="{{ old('map_link', $property->map_link) }}">
                        </div>

                        <!-- Details -->
                        <div class="divider divider-primary">
                            <div class="divider-text">Property Details</div>
                        </div>
                        <div class="row">
                            @php
                                $existingValues = $property->detailValues->pluck('value', 'property_detail_id')->toArray();
                            @endphp
                            @foreach($propertyDetails as $detail)
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="detail-{{ $detail->id }}">
                                        @if($detail->icon)<i class="{{ $detail->icon }} me-1"></i>@endif
                                        {{ $detail->name }}
                                    </label>
                                    @if($detail->input_type == 'select')
                                        <select class="form-select" id="detail-{{ $detail->id }}" name="details[{{ $detail->id }}]">
                                            <option value="">Select</option>
                                            @foreach($detail->options ?? [] as $option)
                                                <option value="{{ $option }}" {{ old('details.'.$detail->id, $existingValues[$detail->id] ?? '') == $option ? 'selected' : '' }}>{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <input type="{{ $detail->input_type }}" class="form-control" id="detail-{{ $detail->id }}" name="details[{{ $detail->id }}]" value="{{ old('details.'.$detail->id, $existingValues[$detail->id] ?? '') }}" placeholder="{{ $detail->name }}">
                                    @endif
                                </div>
                            @endforeach
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="project-id">Project ID</label>
                                <input type="text" class="form-control" id="project-id" name="project_id" value="{{ old('project_id', $property->project_id) }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="is-furnished">Furnishing Status</label>
                                <select class="form-select" id="is-furnished" name="is_furnished" required>
                                    <option value="Unfurnished" {{ old('is_furnished', $property->is_furnished) == 'Unfurnished' ? 'selected' : '' }}>Unfurnished</option>
                                    <option value="Semi-Furnished" {{ old('is_furnished', $property->is_furnished) == 'Semi-Furnished' ? 'selected' : '' }}>Semi-Furnished</option>
                                    <option value="Furnished" {{ old('is_furnished', $property->is_furnished) == 'Furnished' ? 'selected' : '' }}>Furnished</option>
                                </select>
                            </div>
                            <div class="col-md-8 d-flex align-items-center gap-4 mt-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="is-featured" name="is_featured" value="1" {{ old('is_featured', $property->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is-featured">General Featured</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="is-home-featured" name="is_home_featured" value="1" {{ old('is_home_featured', $property->is_home_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is-home-featured">Home Featured</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="is-location-featured" name="is_location_featured" value="1" {{ old('is_location_featured', $property->is_location_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is-location-featured">Location Featured</label>
                                </div>
                            </div>
                        </div>

                        <!-- Amenities -->
                        <div class="divider divider-primary">
                            <div class="divider-text">Amenities</div>
                        </div>
                        <div class="row mb-3">
                            @foreach($amenities as $amenity)
                                <div class="col-md-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="amenities[]" value="{{ $amenity->id }}" id="amenity-{{ $amenity->id }}" {{ $property->amenities->contains($amenity->id) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="amenity-{{ $amenity->id }}">
                                            <i class="{{ $amenity->icon }} me-1"></i> {{ $amenity->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Media -->
                        <div class="divider divider-primary">
                            <div class="divider-text">Media & Links</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Feature Image (Main Thumbnail)</label>
                                @if($property->feature_image)
                                    <div class="mb-2">
                                        <img src="{{ asset($property->feature_image) }}" alt="Feature" width="100" class="rounded border">
                                    </div>
                                @endif
                                <div class="dropzone" id="feature-image-dropzone">
                                    <div class="dz-message text-center">Drag & drop new feature image here</div>
                                </div>
                                <input type="file" class="d-none" id="feature-image-input" name="feature_image">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Gallery Images</label>
                                @if($property->images && count($property->images) > 0)
                                    <div class="d-flex flex-wrap gap-2 mb-2">
                                        @foreach($property->images as $image)
                                            <div class="gallery-image-wrapper">
                                                <img src="{{ asset($image) }}" alt="Gallery" width="80" height="60" style="object-fit: cover" class="rounded border">
                                                <button type="button" class="delete-image-btn" data-path="{{ $image }}" title="Delete">
                                                    <i class="ti ti-x"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="dropzone" id="gallery-images-dropzone">
                                    <div class="dz-message text-center">Drag & drop new images</div>
                                </div>
                                <input type="file" class="d-none" id="gallery-images-input" name="images[]" multiple>
                                <small class="text-muted">Uploading new images will append to existing ones.</small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Floor Plan Image</label>
                                @if($property->floor_plan)
                                    <div class="mb-2">
                                        <img src="{{ asset($property->floor_plan) }}" alt="Floor Plan" width="100" class="rounded border">
                                    </div>
                                @endif
                                <div class="dropzone" id="floor-plan-dropzone">
                                    <div class="dz-message text-center">Drag & drop new floor plan here</div>
                                </div>
                                <input type="file" class="d-none" id="floor-plan-input" name="floor_plan">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="video-link">Video Tour Link (YouTube/Vimeo)</label>
                            <input type="text" class="form-control" id="video-link" name="video_link" value="{{ old('video_link', $property->video_link) }}">
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg w-100">Update Property</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/dropzone/dropzone.css') }}">
    <style>
        .note-editor {
            background: #fff;
        }
        .dropzone {
            border: 2px dashed #d9dee3;
            border-radius: 0.5rem;
            background: #f8f9fa;
            min-height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        .dropzone .dz-message {
            font-size: 1rem;
            font-weight: 500;
        }
        .gallery-image-wrapper {
            position: relative;
            display: inline-block;
        }
        .delete-image-btn {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ff3e1d;
            color: #fff;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            font-size: 12px;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
        }
    </style>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="{{ asset('assets/vendor/libs/dropzone/dropzone.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Summernote
            $('#property-description').summernote({
                placeholder: 'Enter detailed property description...',
                tabsize: 2,
                height: 300,
                toolbar: [
                  ['style', ['style']],
                  ['font', ['bold', 'underline', 'clear']],
                  ['color', ['color']],
                  ['para', ['ul', 'ol', 'paragraph']],
                  ['table', ['table']],
                  ['insert', ['link', 'picture', 'video']],
                  ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            // Dropzone Configuration
            Dropzone.autoDiscover = false;

            // Feature Image Dropzone
            var featureDropzone = new Dropzone("#feature-image-dropzone", {
                url: "#",
                autoProcessQueue: false,
                maxFiles: 1,
                acceptedFiles: "image/*",
                addRemoveLinks: true,
                init: function() {
                    this.on("addedfile", function(file) {
                        if (this.files.length > 1) {
                            this.removeFile(this.files[0]);
                        }
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        document.getElementById('feature-image-input').files = dataTransfer.files;
                    });
                    this.on("removedfile", function() {
                        document.getElementById('feature-image-input').value = "";
                    });
                }
            });

            // Gallery Images Dropzone
            var galleryDropzone = new Dropzone("#gallery-images-dropzone", {
                url: "#",
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 10,
                acceptedFiles: "image/*",
                addRemoveLinks: true,
                init: function() {
                    var dz = this;
                    this.on("addedfile", function(file) {
                        updateGalleryInput(dz);
                    });
                    this.on("removedfile", function(file) {
                        updateGalleryInput(dz);
                    });
                }
            });

            function updateGalleryInput(dz) {
                const dataTransfer = new DataTransfer();
                dz.files.forEach(file => {
                    dataTransfer.items.add(file);
                });
                document.getElementById('gallery-images-input').files = dataTransfer.files;
            }

            // Floor Plan Dropzone
            var floorPlanDropzone = new Dropzone("#floor-plan-dropzone", {
                url: "#",
                autoProcessQueue: false,
                maxFiles: 1,
                acceptedFiles: "image/*",
                addRemoveLinks: true,
                init: function() {
                    this.on("addedfile", function(file) {
                        if (this.files.length > 1) {
                            this.removeFile(this.files[0]);
                        }
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        document.getElementById('floor-plan-input').files = dataTransfer.files;
                    });
                    this.on("removedfile", function() {
                        document.getElementById('floor-plan-input').value = "";
                    });
                }
            });

            // Delete Image AJAX
            $('.delete-image-btn').on('click', function(e) {
                e.preventDefault();
                var btn = $(this);
                var imagePath = btn.data('path');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This image will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.property.image.delete', $property->id) }}",
                            type: 'POST',
                            data: {
                                image_path: imagePath,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                if (response.success) {
                                    btn.closest('.gallery-image-wrapper').fadeOut(300, function() {
                                        $(this).remove();
                                    });
                                    Swal.fire('Deleted!', response.message, 'success');
                                } else {
                                    Swal.fire('Error!', response.message, 'error');
                                }
                            },
                            error: function() {
                                Swal.fire('Error!', 'Something went wrong.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
