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

    <!-- Fonts: Inter is self-hosted in the site CSS bundle (resources/css/fonts.css) -->

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
{{-- Prerender property and listing pages when a link is hovered (~200ms).
     Property links open in a new tab, hence the target_hint copy of the rule. --}}
<script type="speculationrules">
{
    "prerender": [
        {"where": {"href_matches": "/property-details/*"}, "eagerness": "moderate", "target_hint": "_blank"},
        {"where": {"href_matches": "/property-details/*"}, "eagerness": "moderate"},
        {"where": {"or": [
            {"href_matches": "/rent"}, {"href_matches": "/buy"}, {"href_matches": "/sell"},
            {"href_matches": "/location/*"}
        ]}, "eagerness": "moderate"}
    ]
}
</script>
</body>
<!-- endbuild -->
