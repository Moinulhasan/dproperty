<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- SEO Meta Tags -->
<title>DProperty - Professional Property Solutions & Real Estate Services</title>
<meta name="description" content="Leading property solutions company offering real estate services, property management, buying, selling, and rental services in Bangladesh. Expert property consultants with 24/7 support.">
<meta name="keywords" content="property, real estate, property management, buy property, sell property, rent property, Bangladesh property, Dhaka real estate">
<meta name="author" content="DProperty">
<meta name="robots" content="index, follow">

<!-- Open Graph Meta Tags -->
<meta property="og:title" content="DProperty - Professional Property Solutions">
<meta property="og:description" content="{{$settings->site_description??'Leading property solutions company in Bangladesh offering comprehensive real estate services.'}}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{env('APP_URL')}}">
<meta property="og:image" content="{{$settings->favicon??asset('images/logo_main.png')}}">

<!-- Twitter Card Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="DProperty - Professional Property Solutions">
<meta name="twitter:description" content="{{$settings->site_description??'Leading property solutions company in Bangladesh offering comprehensive real estate services.'}}">

<!-- Favicon -->
<link rel="icon" type="image/png" href="{{$settings->favicon??asset('images/logo_main.png')}}">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="{{asset('css/main.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/freeps2/a7rarpress@main/swiper-bundle.min.css">
<link rel="stylesheet" href="{{asset('css/custom_slider.css')}}">
<script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "RealEstateAgent",
      "name": "DProperty",
      "description": "Professional property solutions and real estate services",
      "url": "{{env('APP_URL')}}",
      "telephone": "{{$settings->phone??'+8801234567890'}}",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "{{$settings->address??'"123 Business Street, Suite 100"'}}",
        "addressLocality": "Dhaka",
        "addressCountry": "BD"
      }
    }
</script>
