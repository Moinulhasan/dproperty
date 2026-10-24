<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- SEO Meta Tags -->
<title>DProperty - Professional Property Solutions & Real Estate Services</title>
<meta name="description" content="Leading property solutions company offering real estate services, property management, buying, selling, and rental services in Bangladesh. Expert property consultants with 24/7 support.">
<meta name="keywords" content="property, real estate, property management, buy property, sell property, rent property, Bangladesh property, Dhaka real estate">
<meta name="author" content="DProperty">
<meta name="robots" content="index, follow">

<!-- Open Graph Meta Tags -->
<meta property="og:site_name" content="DProperty">
<meta property="og:title" content="DProperty - Professional Property Solutions">
<meta property="og:description" content="{{$settings->site_description??'Leading property solutions company in Bangladesh offering comprehensive real estate services.'}}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ ($settings->og_image ?? null) ? asset($settings->og_image) : ($settings->logo ?? asset('images/logo_main.png')) }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:locale" content="en_BD">

<!-- Twitter Card Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="DProperty - Professional Property Solutions">
<meta name="twitter:description" content="{{$settings->site_description??'Leading property solutions company in Bangladesh offering comprehensive real estate services.'}}">
<meta name="twitter:image" content="{{ ($settings->og_image ?? null) ? asset($settings->og_image) : ($settings->logo ?? asset('images/logo_main.png')) }}">

<!-- Favicon -->
<link rel="icon" type="image/png" href="{{$settings->favicon??asset('images/logo_main.png')}}">

<!-- Site CSS bundle (Inter, Bootstrap, icons, Swiper, site styles): resources/css/site.css -->
@vite('resources/css/site.css')
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
