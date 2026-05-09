@extends('master')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/post-property.css') }}">
@endsection

@section('content')
<div class="post-property-hero">
    <div class="container px-md-5 px-3">
        <nav aria-label="breadcrumb" class="breadcrumb-listing mb-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Post Property</li>
            </ol>
        </nav>
        <h1>Sell or Rent your Property</h1>
        <p class="mb-0 text-white-50">Submit your property details and our team will get back to you shortly.</p>
    </div>
</div>

<section class="post-property-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="post-property-card">
                    <div class="card-header-badge">
                        <span>You are posting this property for <strong class="badge-highlight">FREE</strong></span>
                    </div>

                    <form action="{{ route('post-property.submit') }}" method="POST" id="postPropertyForm">
                        @csrf

                        {{-- Want To --}}
                        <div class="form-section">
                            <label class="section-label required">I Want to</label>
                            <div class="radio-group">
                                <label class="radio-card {{ old('want_to', 'Sale') == 'Sale' ? 'active' : '' }}">
                                    <input type="radio" name="want_to" value="Sale" {{ old('want_to', 'Sale') == 'Sale' ? 'checked' : '' }}>
                                    <i class="fas fa-tag"></i>
                                    <span>Sale</span>
                                </label>
                                <label class="radio-card {{ old('want_to') == 'Rent' ? 'active' : '' }}">
                                    <input type="radio" name="want_to" value="Rent" {{ old('want_to') == 'Rent' ? 'checked' : '' }}>
                                    <i class="fas fa-key"></i>
                                    <span>Rent</span>
                                </label>
                            </div>
                        </div>

                        {{-- Property Type --}}
                        <div class="form-section">
                            <label class="section-label required">Property Type</label>
                            <div class="tab-group" id="propertyTypeGroup">
                                <button type="button" class="tab-btn {{ old('property_type', 'Residential') == 'Residential' ? 'active' : '' }}" data-value="Residential">
                                    <i class="fas fa-home"></i> Residential
                                </button>
                                <button type="button" class="tab-btn {{ old('property_type') == 'Commercial' ? 'active' : '' }}" data-value="Commercial">
                                    <i class="fas fa-building"></i> Commercial
                                </button>
                            </div>
                            <input type="hidden" name="property_type" id="propertyTypeInput" value="{{ old('property_type', 'Residential') }}">
                        </div>

                        {{-- Property Category --}}
                        <div class="form-section">
                            <label class="section-label required">Property Category</label>
                            <div class="category-pills" id="categoryPills">
                                {{-- Residential Categories --}}
                                <div class="category-set" id="residentialCategories">
                                    @php
                                        $residentialCats = ['Simplex', 'Duplex', 'Independent house/full building', 'land'];
                                    @endphp
                                    @foreach($residentialCats as $cat)
                                        <button type="button" class="pill-btn {{ old('property_category') == $cat ? 'active' : '' }}" data-value="{{ $cat }}">{{ $cat }}</button>
                                    @endforeach
                                </div>
                                {{-- Commercial Categories --}}
                                <div class="category-set" id="commercialCategories" style="display:none;">
                                    @php
                                        $commercialCats = ['Office', 'godown', 'full building', 'land'];
                                    @endphp
                                    @foreach($commercialCats as $cat)
                                        <button type="button" class="pill-btn {{ old('property_category') == $cat ? 'active' : '' }}" data-value="{{ $cat }}">{{ $cat }}</button>
                                    @endforeach
                                </div>
                            </div>
                            <input type="hidden" name="property_category" id="propertyCategoryInput" value="{{ old('property_category') }}">
                        </div>

                        {{-- Furnished Type --}}
                        <div class="form-section">
                            <label class="section-label">Type</label>
                            <div class="tab-group">
                                @php $furnishedOptions = ['Full Furnished', 'Semi Furnished', 'Non Furnished']; @endphp
                                @foreach($furnishedOptions as $opt)
                                    <button type="button" class="tab-btn furnished-btn {{ old('furnished_type') == $opt ? 'active' : '' }}" data-value="{{ $opt }}">{{ $opt }}</button>
                                @endforeach
                            </div>
                            <input type="hidden" name="furnished_type" id="furnishedTypeInput" value="{{ old('furnished_type') }}">
                        </div>

                        {{-- Facing --}}
                        <div class="form-section">
                            <label class="section-label">Facing</label>
                            <div class="category-pills">
                                @php
                                    $facingOptions = ['North', 'East', 'South', 'West', 'South East Corner', 'South West Corner', 'North East Corner', 'North West Corner'];
                                @endphp
                                @foreach($facingOptions as $face)
                                    <button type="button" class="pill-btn facing-btn {{ old('facing') == $face ? 'active' : '' }}" data-value="{{ $face }}">{{ $face }}</button>
                                @endforeach
                            </div>
                            <input type="hidden" name="facing" id="facingInput" value="{{ old('facing') }}">
                        </div>

                        {{-- SFT & Price --}}
                        <div class="form-section">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="section-label">SFT (Square Feet)</label>
                                    <div class="input-icon-group">
                                        <i class="fas fa-ruler-combined"></i>
                                        <input type="number" name="sft" class="form-input" placeholder="e.g. 1200" value="{{ old('sft') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="section-label">Price (BDT)</label>
                                    <div class="input-icon-group">
                                        <i class="fas fa-money-bill-wave"></i>
                                        <input type="number" name="price" class="form-input" placeholder="e.g. 5000000" value="{{ old('price') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Address --}}
                        <div class="form-section">
                            <label class="section-label required">Address</label>
                            <div class="input-icon-group">
                                <i class="fas fa-map-marker-alt"></i>
                                <input type="text" name="address" class="form-input" placeholder="Full property address" value="{{ old('address') }}" required>
                            </div>
                        </div>

                        {{-- Name & Phone --}}
                        <div class="form-section">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="section-label required">Name</label>
                                    <div class="input-icon-group">
                                        <i class="fas fa-user"></i>
                                        <input type="text" name="name" class="form-input" placeholder="Your full name" value="{{ old('name') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="section-label required">Phone Number</label>
                                    <div class="input-icon-group">
                                        <i class="fas fa-phone"></i>
                                        <input type="text" name="phone" class="form-input" placeholder="e.g. 01XXXXXXXXX" value="{{ old('phone') }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="form-section">
                            <label class="section-label">Email</label>
                            <div class="input-icon-group">
                                <i class="fas fa-envelope"></i>
                                <input type="email" name="email" class="form-input" placeholder="your@email.com" value="{{ old('email') }}">
                            </div>
                        </div>

                        {{-- Message --}}
                        <div class="form-section">
                            <label class="section-label">Message</label>
                            <textarea name="message" class="form-textarea" rows="4" placeholder="Describe your property, any special features or requirements...">{{ old('message') }}</textarea>
                        </div>

                        {{-- Submit --}}
                        <div class="form-section text-center">
                            <button type="submit" class="btn-submit-property">
                                <i class="fas fa-paper-plane me-2"></i> Submit Property
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Radio card selection
    document.querySelectorAll('.radio-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.radio-card').forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            this.querySelector('input[type="radio"]').checked = true;
        });
    });

    // Property Type tabs
    const propertyTypeBtns = document.querySelectorAll('#propertyTypeGroup .tab-btn');
    propertyTypeBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            propertyTypeBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('propertyTypeInput').value = this.dataset.value;

            // Toggle category sets
            if (this.dataset.value === 'Residential') {
                document.getElementById('residentialCategories').style.display = 'flex';
                document.getElementById('commercialCategories').style.display = 'none';
            } else {
                document.getElementById('residentialCategories').style.display = 'none';
                document.getElementById('commercialCategories').style.display = 'flex';
            }
            // Clear previous category selection
            document.querySelectorAll('#categoryPills .pill-btn').forEach(p => p.classList.remove('active'));
            document.getElementById('propertyCategoryInput').value = '';
        });
    });

    // Category pills
    document.querySelectorAll('#categoryPills .pill-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Only deselect pills in the same category set
            this.closest('.category-set').querySelectorAll('.pill-btn').forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('propertyCategoryInput').value = this.dataset.value;
        });
    });

    // Furnished type tabs
    document.querySelectorAll('.furnished-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.furnished-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('furnishedTypeInput').value = this.dataset.value;
        });
    });

    // Facing pills
    document.querySelectorAll('.facing-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.facing-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('facingInput').value = this.dataset.value;
        });
    });
});
</script>
@endpush
