<!doctype html>

<html
    lang="en"
    class="light-style layout-wide customizer-hide"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../../assets/"
    data-template="vertical-menu-template">
<head>
    <meta charset="utf-8"/>
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>

    <title>Login</title>

    <meta name="description" content=""/>

    @include('admin.include.dist.meta')
    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}"/>
</head>

<body>
<!-- Content -->

<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
            <!-- Login -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mb-4 mt-2">
                        <a href="index.html" class="app-brand-link gap-2">
                            <img src="{{asset('images/logo.png')}}" alt="" class="app-brand-logo"
                                 style="height: 50px; width: 100px;">
                        </a>
                    </div>
                    <!-- /Logo -->
                    {{--                    <p class="mb-4">Please sign-in to your account</p>--}}

                    <form id="formAuthentication" class="mb-3" action="{{route('admin.postlogin')}}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input
                                type="text"
                                class="form-control"
                                id="email"
                                name="email"
                                placeholder="Enter your email or username"
                                autofocus/>
                        </div>

                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">Password</label>
                            </div>
                            <div class="input-group input-group-merge">
                                <input
                                    type="password"
                                    id="password"
                                    class="form-control"
                                    name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password"/>
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                        </div>
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="invalid-feedback" style="display: block">
                                    <p>{{$error}}</p>
                                </div>
                            @endforeach
                        @endif
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                        </div>
                    </form>
                </div>

            </div>
            <!-- /Register -->
        </div>
    </div>
</div>

<!-- / Content -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
@include('admin.include.dist.script')
<!-- Page JS -->
<script src="{{asset('assets/js/pages-auth.js')}}"></script>
</body>
</html>
