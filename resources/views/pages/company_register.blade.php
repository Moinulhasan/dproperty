@extends('master')

@section('title', 'Create Your DProperty Account — Register your company')
@section('meta_description', 'Register your company on DProperty to list properties for sale or rent in Bangladesh.')

@section('styles')
    <style>
        /* Brand palette — matches the rest of the site (var(--primary-color, #006A50)). */
        :root {
            --reg-primary: #006A50;
            --reg-primary-dark: #00553f;
            --reg-primary-soft: #e7f3ee;
            --reg-accent: #E8A317;
        }

        .reg-hero {
            background: linear-gradient(135deg, var(--reg-primary) 0%, var(--reg-primary-dark) 100%);
            color: #fff;
            padding: 28px 0;
        }
        .reg-hero h1 {
            font-size: 1.6rem;
            font-weight: 700;
            margin: 0;
            color: #fff;
        }
        .reg-hero p {
            opacity: .85;
            font-size: .9rem;
            margin: 4px 0 0;
        }
        .reg-hero .brand-mark {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.18);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            margin-right: 14px;
            border: 1px solid rgba(255, 255, 255, 0.25);
        }

        .reg-wrap { background: #f6f7f9; padding: 24px 0 60px; }
        .reg-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,.04);
            padding: 28px;
            margin-bottom: 22px;
        }
        .section-num {
            display: inline-flex;
            width: 26px; height: 26px;
            border-radius: 50%;
            background: var(--reg-primary); color: #fff;
            align-items: center; justify-content: center;
            font-size: .8rem; font-weight: 700;
            margin-right: 8px;
        }
        .reg-card h5 {
            font-weight: 700;
            font-size: 1.05rem;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            color: var(--reg-primary);
        }
        .form-label .req { color: var(--reg-primary); }
        .form-control:focus, .form-select:focus {
            border-color: var(--reg-primary);
            box-shadow: 0 0 0 0.15rem rgba(0, 106, 80, 0.15);
        }
        .form-check-input:checked {
            background-color: var(--reg-primary);
            border-color: var(--reg-primary);
        }
        .upload-box {
            border: 1.5px dashed #cdd1d6;
            border-radius: 8px;
            padding: 18px;
            text-align: center;
            position: relative;
            background: #fafbfc;
            cursor: pointer;
            transition: border-color .2s ease, background .2s ease;
        }
        .upload-box:hover {
            border-color: var(--reg-primary);
            background: var(--reg-primary-soft);
        }
        .upload-box small { color: #97a0aa; display: block; margin-top: 6px; }
        .upload-box input[type=file] {
            position: absolute; inset: 0;
            opacity: 0; cursor: pointer;
        }
        .upload-box .file-name {
            display: block;
            margin-top: 6px;
            color: var(--reg-primary);
            font-size: .82rem;
            font-weight: 600;
        }
        .declaration {
            background: #fff;
            border-radius: 10px;
            padding: 22px 28px;
            box-shadow: 0 2px 10px rgba(0,0,0,.04);
            margin-bottom: 22px;
        }
        .declaration h5 {
            font-weight: 700;
            font-size: 1.05rem;
            margin-bottom: 14px;
            color: var(--reg-primary);
            display: flex;
            align-items: center;
        }
        .declaration a { color: var(--reg-primary); }
        .btn-submit-reg {
            background: var(--reg-primary);
            color: #fff;
            font-weight: 600;
            padding: 12px 28px;
            border: none;
            border-radius: 8px;
            transition: background .2s ease, transform .15s ease;
        }
        .btn-submit-reg:hover {
            background: var(--reg-primary-dark);
            color: #fff;
            transform: translateY(-1px);
        }

        .info-sidebar .info-block {
            background: #fff;
            border-radius: 10px;
            padding: 20px 22px;
            box-shadow: 0 2px 10px rgba(0,0,0,.04);
            margin-bottom: 18px;
            font-size: .88rem;
        }
        .info-sidebar h6 {
            font-weight: 700;
            margin-bottom: 14px;
            font-size: .95rem;
            color: var(--reg-primary);
        }
        .info-sidebar .step-row {
            display: flex;
            gap: 12px;
            margin-bottom: 14px;
        }
        .info-sidebar .step-row:last-child { margin-bottom: 0; }
        .info-sidebar .step-num {
            width: 24px; height: 24px;
            border-radius: 50%;
            background: var(--reg-primary-soft);
            color: var(--reg-primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: .75rem;
            font-weight: 700;
            flex-shrink: 0;
        }
        .info-sidebar .step-row p {
            margin: 0;
            font-size: .82rem;
        }
        .info-sidebar .step-row strong { display: block; font-size: .87rem; }
        .info-sidebar .check li {
            list-style: none;
            padding-left: 22px;
            position: relative;
            margin-bottom: 6px;
            font-size: .85rem;
        }
        .info-sidebar .check li::before {
            content: '✓';
            position: absolute;
            left: 0; top: 0;
            color: var(--reg-primary);
            font-weight: 700;
        }
        .info-sidebar .info-block.notes {
            background: var(--reg-primary-soft);
        }
        .info-sidebar .info-block a { color: var(--reg-primary); }
    </style>
@endsection

@section('content')
<section class="reg-hero">
    <div class="container">
        <div class="d-flex align-items-center">
            <span class="brand-mark"><i class="fas fa-building"></i></span>
            <div>
                <h1>Create Your DProperty Account</h1>
                <p>Register your company to list properties on DProperty</p>
            </div>
        </div>
    </div>
</section>

<div class="reg-wrap">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Please correct the following:</strong>
                <ul class="mb-0">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('company.register.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    {{-- 1. Account Information --}}
                    <div class="reg-card">
                        <h5><span class="section-num">1</span> Account Information</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Company Name <span class="req">*</span></label>
                                <input type="text" name="company_name" class="form-control" placeholder="Enter company name" value="{{ old('company_name') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Contact Person Name <span class="req">*</span></label>
                                <input type="text" name="contact_person_name" class="form-control" placeholder="Enter full name" value="{{ old('contact_person_name') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Designation <span class="req">*</span></label>
                                <input type="text" name="designation" class="form-control" placeholder="Enter designation" value="{{ old('designation') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Email Address <span class="req">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="Enter email address" value="{{ old('email') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Mobile Number <span class="req">*</span></label>
                                <input type="text" name="mobile_number" class="form-control" placeholder="Enter mobile number" value="{{ old('mobile_number') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">WhatsApp Number</label>
                                <input type="text" name="whatsapp_number" class="form-control" placeholder="Enter WhatsApp number" value="{{ old('whatsapp_number') }}">
                            </div>
                        </div>
                        <p class="text-muted small mt-3 mb-0">
                            <i class="fas fa-info-circle me-1"></i>
                            Login credentials will be sent to your email after your account is verified and approved by our team.
                        </p>
                    </div>

                    {{-- 2. Company Information --}}
                    <div class="reg-card">
                        <h5><span class="section-num">2</span> Company Information</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Company Type <span class="req">*</span></label>
                                <select name="company_type" class="form-select">
                                    <option value="">Select company type</option>
                                    @foreach(['Private Limited', 'Public Limited', 'Partnership', 'Sole Proprietorship', 'Other'] as $type)
                                        <option value="{{ $type }}" @selected(old('company_type') == $type)>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Trade License Number <span class="req">*</span></label>
                                <input type="text" name="trade_license_number" class="form-control" placeholder="Enter trade license number" value="{{ old('trade_license_number') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Trade License Expiry Date <span class="req">*</span></label>
                                <input type="date" name="trade_license_expiry" class="form-control" value="{{ old('trade_license_expiry') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">TIN Number</label>
                                <input type="text" name="tin_number" class="form-control" placeholder="Enter TIN number" value="{{ old('tin_number') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">VAT Registration Number (if applicable)</label>
                                <input type="text" name="vat_number" class="form-control" placeholder="Enter VAT number" value="{{ old('vat_number') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Company Website</label>
                                <input type="url" name="company_website" class="form-control" placeholder="Enter website (optional)" value="{{ old('company_website') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Years in Business</label>
                                <select name="years_in_business" class="form-select">
                                    <option value="">Select years in business</option>
                                    @foreach(['<1 year', '1-3 years', '3-5 years', '5-10 years', '10+ years'] as $y)
                                        <option value="{{ $y }}" @selected(old('years_in_business') == $y)>{{ $y }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- 3. Company Address --}}
                    <div class="reg-card">
                        <h5><span class="section-num">3</span> Company Address</h5>
                        <div class="mb-3">
                            <label class="form-label">Office Address <span class="req">*</span></label>
                            <textarea name="office_address" rows="2" class="form-control" placeholder="Enter office address">{{ old('office_address') }}</textarea>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Country <span class="req">*</span></label>
                                <select name="country" class="form-select">
                                    <option value="">Select country</option>
                                    @foreach(['Bangladesh', 'India', 'Pakistan', 'UAE', 'Other'] as $c)
                                        <option value="{{ $c }}" @selected(old('country', 'Bangladesh') == $c)>{{ $c }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">City <span class="req">*</span></label>
                                <input type="text" name="city" class="form-control" placeholder="Select city" value="{{ old('city') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">District <span class="req">*</span></label>
                                <input type="text" name="district" class="form-control" placeholder="Select district" value="{{ old('district') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Postal Code</label>
                                <input type="text" name="postal_code" class="form-control" placeholder="Enter postal code" value="{{ old('postal_code') }}">
                            </div>
                        </div>
                    </div>

                    {{-- 4. Required Document Upload --}}
                    <div class="reg-card">
                        <h5><span class="section-num">4</span> Required Document Upload</h5>
                        <div class="row g-3">
                            @php
                                $docs = [
                                    ['name' => 'trade_license_copy',        'label' => 'Trade License Copy',                                'required' => true,  'hint' => 'PDF, JPG, PNG (Max 5MB)'],
                                    ['name' => 'company_logo',              'label' => 'Company Logo',                                      'required' => false, 'hint' => 'JPG, PNG (Max 2MB)'],
                                    ['name' => 'national_id_passport',      'label' => 'National ID / Passport of Authorized Person',       'required' => true,  'hint' => 'PDF, JPG, PNG (Max 5MB)'],
                                    ['name' => 'tin_certificate',           'label' => 'TIN Certificate',                                   'required' => false, 'hint' => 'PDF, JPG, PNG (Max 5MB)'],
                                    ['name' => 'incorporation_certificate', 'label' => 'Company Incorporation Certificate (Optional)',      'required' => false, 'hint' => 'PDF, JPG, PNG (Max 5MB)'],
                                    ['name' => 'utility_bill',              'label' => 'Utility Bill / Office Address Proof',               'required' => true,  'hint' => 'PDF, JPG, PNG (Max 5MB)'],
                                ];
                            @endphp
                            @foreach($docs as $doc)
                                <div class="col-md-4">
                                    <label class="form-label">
                                        {{ $doc['label'] }}
                                        @if($doc['required'])<span class="req">*</span>@endif
                                    </label>
                                    <label class="upload-box d-block">
                                        <i class="fas fa-cloud-upload-alt text-muted"></i>
                                        <div class="mt-1">Upload File</div>
                                        <small>{{ $doc['hint'] }}</small>
                                        <span class="file-name" data-empty="—"></span>
                                        <input type="file" name="{{ $doc['name'] }}" accept=".pdf,.jpg,.jpeg,.png">
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- 5. Property Listing Information --}}
                    <div class="reg-card">
                        <h5><span class="section-num">5</span> Property Listing Information</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Property Category <span class="req">*</span></label>
                                <select name="property_category" class="form-select">
                                    <option value="">Select property category</option>
                                    @foreach(['Residential', 'Commercial', 'Both'] as $cat)
                                        <option value="{{ $cat }}" @selected(old('property_category') == $cat)>{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Number of Properties to List</label>
                                <select name="number_of_properties" class="form-select">
                                    <option value="">Select number of properties</option>
                                    @foreach(['1-5', '5-10', '10-25', '25+'] as $n)
                                        <option value="{{ $n }}" @selected(old('number_of_properties') == $n)>{{ $n }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Service Required <span class="req">*</span></label>
                                <div class="d-flex gap-3 mt-2">
                                    @foreach(['Sale', 'Rent', 'Lease'] as $svc)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="service_required" id="svc-{{ $svc }}" value="{{ $svc }}" @checked(old('service_required', 'Sale') == $svc)>
                                            <label class="form-check-label" for="svc-{{ $svc }}">{{ $svc }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 6. Declaration --}}
                    <div class="declaration">
                        <h5><span class="section-num">6</span> Declaration</h5>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="declare_accurate" id="decl-acc" value="1">
                            <label class="form-check-label" for="decl-acc">I confirm that all information provided is accurate.</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="declare_authorize" id="decl-auth" value="1">
                            <label class="form-check-label" for="decl-auth">I authorize DProperty to verify my company documents and property ownership information.</label>
                        </div>
                        <div class="form-check mb-0">
                            <input class="form-check-input" type="checkbox" name="declare_terms" id="decl-tnc" value="1">
                            <label class="form-check-label" for="decl-tnc">
                                I agree to the
                                <a href="{{ route('terms-of-use') }}" target="_blank">Terms &amp; Conditions</a>
                                and
                                <a href="{{ route('privacy-policy') }}" target="_blank">Privacy Policy</a>.
                            </label>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between">
                        <button type="submit" class="btn-submit-reg">
                            <i class="fas fa-paper-plane me-1"></i> Submit Registration
                        </button>
                        <small class="text-muted">
                            <i class="fas fa-shield-alt me-1"></i>
                            Your information is secure and protected with our privacy policy.
                        </small>
                    </div>
                </div>

                {{-- Right-rail info — site brand-green palette. --}}
                <div class="col-lg-4 info-sidebar">
                    <div class="info-block">
                        <h6><i class="fas fa-bolt me-1"></i> Registration Process</h6>
                        @php
                            $steps = [
                                ['Submit Registration', 'Fill out the registration form with your company details.'],
                                ['Upload Documents',    'Upload all required documents for verification.'],
                                ['Verification',        'Our team will verify your company details and documents.'],
                                ['Account Approval',    'Get approval within 24-48 hours via email and SMS.'],
                                ['Start Listing',       'Once approved, you can start listing your properties.'],
                            ];
                        @endphp
                        @foreach($steps as $i => $step)
                            <div class="step-row">
                                <span class="step-num">{{ $i + 1 }}</span>
                                <div>
                                    <strong>{{ $step[0] }}</strong>
                                    <p class="text-muted">{{ $step[1] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="info-block">
                        <h6><i class="fas fa-shield-alt me-1"></i> Why Register with DProperty?</h6>
                        <ul class="check ps-0 mb-0">
                            <li>Trusted platform for verified property listings</li>
                            <li>Reach thousands of potential buyers &amp; tenants</li>
                            <li>Easy property management dashboard</li>
                            <li>Secure and transparent process</li>
                        </ul>
                    </div>

                    <div class="info-block notes">
                        <h6><i class="fas fa-exclamation-circle me-1"></i> Important Notes</h6>
                        <ul class="ps-3 mb-0 small text-muted">
                            <li>All fields marked with <span class="req">*</span> are mandatory.</li>
                            <li>Please ensure all documents are clear and valid.</li>
                            <li>False information may lead to account suspension.</li>
                            <li>For any assistance, contact our support team.</li>
                        </ul>
                    </div>

                    <div class="info-block">
                        <h6><i class="fas fa-headset me-1"></i> Need Help?</h6>
                        <p class="small text-muted mb-2">
                            If you have any questions or need assistance with registration, our support team is here to help you.
                        </p>
                        <p class="small mb-1">
                            <i class="fas fa-envelope me-1"></i>
                            {{ $settings->email ?? 'support@dproperty.com' }}
                        </p>
                        <p class="small mb-1">
                            <i class="fas fa-phone me-1"></i>
                            {{ $settings->phone ?? '+880 1234-567890' }}
                        </p>
                        <p class="small mb-0">
                            <i class="far fa-clock me-1"></i>
                            Monday - Friday (10AM - 6PM)
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Reflect chosen file name under each upload box.
    document.querySelectorAll('.upload-box input[type=file]').forEach(function (input) {
        input.addEventListener('change', function () {
            const label = input.closest('.upload-box').querySelector('.file-name');
            if (!label) return;
            label.textContent = input.files.length ? input.files[0].name : '';
        });
    });
</script>
@endpush
@endsection
