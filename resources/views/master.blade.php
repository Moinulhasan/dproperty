<!doctype html>

<html
    lang="en"
    class="light-style layout-menu-fixed layout-compact"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path=""
    data-template="horizontal-menu-template-no-customizer">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="theme-color" content="#006A50"/>

    <title>@yield('title', 'Dproperty')</title>

    <meta name="description" content="@yield('meta_description', 'Your premium real estate partner')"/>
    <link rel="canonical" href="@yield('canonical_url', url()->current())"/>
    @yield('seo')

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{$settings->favicon ?? asset('images/logo_main.png')}}"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet"/>

    <!-- Icons -->
    @include('include.header')
    @yield('styles')
</head>

<body>
@include('component.nav')
@yield('content')
@include('component.footer')
@include('include.script')
@yield('scripts')
@stack('scripts')
</body>
<!-- endbuild -->
