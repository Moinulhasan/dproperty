@extends('admin.master')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/bs-stepper/bs-stepper.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}"/>
@endsection
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
                    <h5 class="mb-0">Settings</h5>
                </div>
            </div>
            <div class="">
                <div class="col-12 mb-4">
                    <div class="bs-stepper vertical wizard-vertical-icons-example mt-2">
                        <div class="bs-stepper-header">
                            <div class="step" data-target="#account-details-vertical">
                                <button type="button" class="step-trigger">
                          <span class="bs-stepper-circle">
                            <i class="ti ti-file-description"></i>
                          </span>
                                    <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Basic Details</span>
                            <span class="bs-stepper-subtitle">Setup Basic Details</span>
                          </span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#personal-info-vertical">
                                <button type="button" class="step-trigger">
                          <span class="bs-stepper-circle">
                            <i class="ti ti-map"></i>
                          </span>
                                    <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Contact Info</span>
                            <span class="bs-stepper-subtitle">Add Contact info</span>
                          </span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#social-links-vertical">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-circle"><i class="ti ti-brand-instagram"></i> </span>
                                    <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Social Links</span>
                            <span class="bs-stepper-subtitle">Add social links</span>
                          </span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#why-us-vertical">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-circle"><i class="ti ti-award"></i></span>
                                    <span class="bs-stepper-label">
                            <span class="bs-stepper-title">Why Choose Us</span>
                            <span class="bs-stepper-subtitle">Manage benefit items</span>
                          </span>
                                </button>
                            </div>
                        </div>
                        <div class="bs-stepper-content">
                            <form action="{{route('admin.app.settings.update')}}"
                                  method="post" enctype="multipart/form-data">
                                @csrf
                                @method('post')
                                <!-- Account Details -->
                                <div id="account-details-vertical" class="content">
                                    <div class="content-header mb-3">
                                        <h6 class="mb-0">Basic Details</h6>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <label class="form-label" for="email1">Logo</label>
                                            <input
                                                type="file"
                                                id="email1"
                                                class="form-control"
                                                name="site_logo"
                                                aria-label="john.doe"/>
                                            <div class="mt-2">
                                                @if(isset($settings->logo))
                                                    <img src="{{$settings->logo}}" alt="dproperty" srcset=""
                                                         style="height: 50px;width: 100px;">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6 form-password-toggle">
                                            <label class="form-label" for="confirm-password61">Favicon</label>
                                            <input
                                                type="file"
                                                id="email1"
                                                class="form-control"
                                                name="favicon"
                                                aria-label="john.doe"/>
                                            <div class="mt-2">
                                                @if(isset($settings->favicon))
                                                    <img src="{{$settings->favicon}}" alt="dproperty" srcset=""
                                                         style="height: 50px;width: 100px;">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6 form-password-toggle">
                                            <label class="form-label" for="og-image">Social Share Image (og:image)</label>
                                            <input
                                                type="file"
                                                id="og-image"
                                                class="form-control"
                                                name="og_image"
                                                aria-label="og-image"/>
                                            <div class="form-text">Recommended: 1200&times;630 px. Used as the default preview when pages are shared on Facebook, LinkedIn, Twitter, etc.</div>
                                            <div class="mt-2">
                                                @if(isset($settings->og_image))
                                                    <img src="{{ asset($settings->og_image) }}" alt="og:image preview" style="height: 60px;width: auto;">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6 form-password-toggle">
                                            <label class="form-label" for="password60">Short Description</label>

                                            <textarea name="site_description" id=""
                                                      class="form-control">{{$settings?->site_description}}</textarea>
                                        </div>
                                        <div class="col-12 d-flex justify-content-between">
                                            <button class="btn btn-label-secondary btn-prev" disabled>
                                                <i class="ti ti-arrow-left me-sm-1"></i>
                                                <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                            </button>
                                            <a class="btn btn-primary btn-next">
                                                <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                                <i class="ti ti-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Personal Info -->
                                <div id="personal-info-vertical" class="content">
                                    <div class="content-header mb-3">
                                        <h6 class="mb-0">Address Info</h6>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <label class="form-label" for="first-name1">Address</label>
                                            <input type="text" id="first-name1" class="form-control"
                                                   placeholder="John" name="site_address"
                                                   value="{{$settings?->address?:''}}"/>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="last-name1">Google Map Link</label>
                                            <input type="text" name="site_google_map" id="last-name1"
                                                   class="form-control"
                                                   placeholder="Doe" value="{{$settings?->google_map?:''}}"/>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="last-name1">Phone Number</label>
                                            <input type="text" name="site_phone" id="last-name1" class="form-control"
                                                   placeholder="Doe" value="{{$settings?->phone?:''}}"/>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="last-name1">Email</label>
                                            <input type="email" name="site_email" id="last-name1" class="form-control"
                                                   placeholder="Doe" value="{{$settings?->email?:''}}"/>
                                        </div>
                                        '
                                        <div class="col-12 d-flex justify-content-between">
                                            <a class="btn btn-label-secondary btn-prev">
                                                <i class="ti ti-arrow-left me-sm-1"></i>
                                                <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                            </a>
                                            <a class="btn btn-primary btn-next">
                                                <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                                <i class="ti ti-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Social Links -->
                                <div id="social-links-vertical" class="content">
                                    <div class="content-header mb-3">
                                        <h6 class="mb-0">Social Links</h6>
                                        <small>Enter Your Social Links.</small>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <label class="form-label" for="facebook1">Facebook</label>
                                            <input
                                                type="text"
                                                id="facebook1"
                                                class="form-control"
                                                name="facebook_link"
                                                placeholder="https://facebook.com/abc"
                                                value="{{$settings?->facebook}}"/>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="google1">Instagram</label>
                                            <input
                                                type="text"
                                                id="google1"
                                                class="form-control"
                                                name="instagram_link"
                                                placeholder="https://instagram.com/abc"
                                                value="{{$settings?->instagram}}"/>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="linkedin1">Youtube</label>
                                            <input
                                                type="text"
                                                id="linkedin1"
                                                class="form-control"
                                                placeholder="https://youtube.com/abc"
                                                name="youtube_link" value="{{$settings?->youtube}}"/>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="linkedin1">Twitter</label>
                                            <input
                                                type="text"
                                                id="twitter"
                                                class="form-control"
                                                placeholder="https://youtube.com/abc"
                                                name="twitter_link" value="{{$settings?->twitter}}"/>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="linkedin1">LinkedIn</label>
                                            <input
                                                type="text"
                                                id="linkedin1"
                                                class="form-control"
                                                placeholder="https://youtube.com/abc"
                                                name="linkedin_link" value="{{$settings?->linkedin}}"/>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="linkedin1">Pinterest</label>
                                            <input
                                                type="text"
                                                id="twitter"
                                                class="form-control"
                                                placeholder="https://youtube.com/abc"
                                                name="pinterest_link" value="{{$settings?->pinterest}}"/>
                                        </div>
                                        <div class="col-12 d-flex justify-content-between">
                                            <a class="btn btn-label-secondary btn-prev">
                                                <i class="ti ti-arrow-left me-sm-1"></i>
                                                <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                            </a>
                                            <a class="btn btn-primary btn-next">
                                                <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                                <i class="ti ti-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Why Choose Us -->
                                <div id="why-us-vertical" class="content">
                                    <div class="content-header mb-3">
                                        <h6 class="mb-0">Why Choose Us</h6>
                                        <small>Section image, title, tagline, and the list of benefit items shown on the home page.</small>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <label class="form-label" for="why-us-image">Section Image</label>
                                            <input
                                                type="file"
                                                id="why-us-image"
                                                class="form-control"
                                                name="contact_image"
                                                aria-label="Why Choose Us image"/>
                                            <div class="mt-2">
                                                @if(isset($settings->contact_image))
                                                    <img src="{{ $settings->contact_image }}" alt="Why Choose Us preview" style="height: 60px;width: auto;">
                                                @endif
                                            </div>
                                            <div class="form-text">Shown next to the benefit items on the home page.</div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label" for="why-us-title">Section Title</label>
                                            <input type="text" id="why-us-title" name="why_us_title" class="form-control" placeholder="Why Choose Us?" value="{{ $settings?->why_us_title }}">
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="form-label" for="why-us-tagline">Tagline</label>
                                            <textarea id="why-us-tagline" name="why_us_tagline" class="form-control" rows="2" placeholder="We are committed to delivering exceptional results...">{{ $settings?->why_us_tagline }}</textarea>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <label class="form-label mb-0">Benefit Items</label>
                                                <button type="button" id="why-us-add" class="btn btn-sm btn-primary">
                                                    <i class="ti ti-plus me-1"></i> Add Item
                                                </button>
                                            </div>
                                            <small class="text-muted d-block mb-2">Each item shows as a check-mark row beside the contact image on the home page.</small>
                                            @php
                                                $existingItems = $settings?->why_us_items ?? [];
                                                if (empty($existingItems)) {
                                                    // Seed the editor with the legacy hardcoded list so the
                                                    // admin doesn't see an empty page on first visit. These
                                                    // are pre-fill values only — they aren't persisted until
                                                    // the admin clicks Submit.
                                                    $existingItems = [
                                                        ['title' => 'Expert Team', 'description' => 'Our experienced professionals bring years of industry expertise to every project.'],
                                                        ['title' => 'Quality Assurance', 'description' => 'We maintain the highest standards of quality in all our deliverables.'],
                                                        ['title' => '24/7 Support', 'description' => 'Round-the-clock support to ensure your business never stops running.'],
                                                        ['title' => 'Competitive Pricing', 'description' => 'Affordable solutions without compromising on quality or service.'],
                                                    ];
                                                }
                                            @endphp
                                            <div id="why-us-items">
                                                @foreach($existingItems as $idx => $item)
                                                    <div class="row g-2 align-items-start mb-2 why-us-row">
                                                        <div class="col-md-4">
                                                            <input type="text" name="why_us_items[{{ $idx }}][title]" class="form-control" placeholder="Item title" value="{{ $item['title'] ?? '' }}">
                                                        </div>
                                                        <div class="col-md-7">
                                                            <input type="text" name="why_us_items[{{ $idx }}][description]" class="form-control" placeholder="Short description" value="{{ $item['description'] ?? '' }}">
                                                        </div>
                                                        <div class="col-md-1 d-grid">
                                                            <button type="button" class="btn btn-outline-danger why-us-remove" title="Remove">
                                                                <i class="ti ti-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-between">
                                            <a class="btn btn-label-secondary btn-prev">
                                                <i class="ti ti-arrow-left me-sm-1"></i>
                                                <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                            </a>
                                            <button class="btn btn-success" type="submit">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('assets/vendor/libs/bs-stepper/bs-stepper.js')}}"></script>
    <script src="{{asset("assets/vendor/libs/bootstrap-select/bootstrap-select.js")}}"></script>
    <script src="{{asset("assets/vendor/libs/select2/select2.js")}}"></script>
    <script src="{{asset('assets/js/form-wizard-icons.js')}}"></script>
    <script>
        // Why Choose Us — dynamic item rows. Add appends a new row; Remove
        // deletes a row. We reindex name="why_us_items[N][...]" after every
        // mutation so the controller sees a clean 0-based array.
        document.addEventListener('DOMContentLoaded', function () {
            const list = document.getElementById('why-us-items');
            const addBtn = document.getElementById('why-us-add');
            if (!list || !addBtn) return;

            const reindex = () => {
                list.querySelectorAll('.why-us-row').forEach((row, idx) => {
                    row.querySelectorAll('input').forEach((input) => {
                        input.name = input.name.replace(/why_us_items\[\d+\]/, `why_us_items[${idx}]`);
                    });
                });
            };

            const buildRow = (idx) => {
                const row = document.createElement('div');
                row.className = 'row g-2 align-items-start mb-2 why-us-row';
                row.innerHTML = `
                    <div class="col-md-4">
                        <input type="text" name="why_us_items[${idx}][title]" class="form-control" placeholder="Item title">
                    </div>
                    <div class="col-md-7">
                        <input type="text" name="why_us_items[${idx}][description]" class="form-control" placeholder="Short description">
                    </div>
                    <div class="col-md-1 d-grid">
                        <button type="button" class="btn btn-outline-danger why-us-remove" title="Remove">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                `;
                return row;
            };

            addBtn.addEventListener('click', () => {
                const idx = list.querySelectorAll('.why-us-row').length;
                list.appendChild(buildRow(idx));
            });

            list.addEventListener('click', (e) => {
                const btn = e.target.closest('.why-us-remove');
                if (!btn) return;
                const row = btn.closest('.why-us-row');
                if (!row) return;
                row.remove();
                reindex();
            });
        });
    </script>
@endsection
