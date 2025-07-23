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
                                                @if($settings->logo)
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
                                                @if($settings->favicon)
                                                    <img src="{{$settings->favicon}}" alt="dproperty" srcset=""
                                                         style="height: 50px;width: 100px;">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6 form-password-toggle">
                                            <label class="form-label" for="confirm-password61">Contact Us</label>
                                            <input
                                                type="file"
                                                id="email1"
                                                class="form-control"
                                                name="contact_image"
                                                aria-label="john.doe"/>
                                            <div class="mt-2">
                                                @if($settings->contact_image)
                                                    <img src="{{$settings->contact_image}}" alt="dproperty" srcset=""
                                                         style="height: 50px;width: 100px;">
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
                                            <button class="btn btn-success " type="submit">Submit</button>
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
@endsection
