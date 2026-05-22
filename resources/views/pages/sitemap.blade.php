@extends('master')

@section('title', 'Sitemap — DProperty')
@section('meta_description', 'Browse every page and section of the DProperty website. Find listings, services, blog, and information pages all in one place.')

@section('seo')
    @include('component._breadcrumb_jsonld', ['crumbs' => [
        ['name' => 'Home',    'url' => route('home')],
        ['name' => 'Sitemap', 'url' => route('site-map')],
    ]])
@endsection

@section('content')
    <main class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <article class="sitemap-content">
                        <header class="mb-5 text-center">
                            <h1 class="display-4 fw-bold text-primary mb-3">Website Sitemap</h1>
                            <p class="lead text-muted">Navigate every section of DProperty in one place.</p>
                        </header>

                        <div class="row g-4">
                            <!-- Main Pages -->
                            <div class="col-lg-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-primary text-white">
                                        <h2 class="h5 mb-0"><i class="bi bi-house-door me-2"></i>Main Pages</h2>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-2"><a href="{{ route('home') }}" class="text-decoration-none text-primary fw-semibold"><i class="bi bi-arrow-right me-2"></i>Home</a></li>
                                            <li class="mb-2"><a href="{{ route('buy') }}" class="text-decoration-none text-primary fw-semibold"><i class="bi bi-arrow-right me-2"></i>Buy Properties</a></li>
                                            <li class="mb-2"><a href="{{ route('rent') }}" class="text-decoration-none text-primary fw-semibold"><i class="bi bi-arrow-right me-2"></i>Rent Properties</a></li>
                                            <li class="mb-2"><a href="{{ route('sell') }}" class="text-decoration-none text-primary fw-semibold"><i class="bi bi-arrow-right me-2"></i>Sell Properties</a></li>
                                            <li class="mb-2"><a href="{{ route('post-property') }}" class="text-decoration-none text-primary fw-semibold"><i class="bi bi-arrow-right me-2"></i>Post Your Property</a></li>
                                            <li class="mb-2"><a href="{{ route('service') }}" class="text-decoration-none text-primary fw-semibold"><i class="bi bi-arrow-right me-2"></i>Our Services</a></li>
                                            <li class="mb-2"><a href="{{ route('about-us') }}" class="text-decoration-none text-primary fw-semibold"><i class="bi bi-arrow-right me-2"></i>About Us</a></li>
                                            <li class="mb-2"><a href="{{ route('contact') }}" class="text-decoration-none text-primary fw-semibold"><i class="bi bi-arrow-right me-2"></i>Contact Us</a></li>
                                            <li class="mb-2"><a href="{{ route('blog') }}" class="text-decoration-none text-primary fw-semibold"><i class="bi bi-arrow-right me-2"></i>Blog</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Locations -->
                            <div class="col-lg-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-info text-white">
                                        <h2 class="h5 mb-0"><i class="bi bi-geo-alt me-2"></i>Browse by Location</h2>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-unstyled mb-0">
                                            @forelse($locations as $loc)
                                                <li class="mb-2">
                                                    <a href="{{ route('location.properties', $loc->id) }}" class="text-decoration-none text-info fw-semibold">
                                                        <i class="bi bi-arrow-right me-2"></i>Properties in {{ $loc->name }}
                                                    </a>
                                                </li>
                                            @empty
                                                <li class="text-muted">No locations available yet.</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Articles -->
                            <div class="col-lg-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-success text-white">
                                        <h2 class="h5 mb-0"><i class="bi bi-journal-text me-2"></i>Latest Articles</h2>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-unstyled mb-0">
                                            @forelse($articles as $article)
                                                <li class="mb-2">
                                                    <a href="{{ route('article-details', $article->slug) }}" class="text-decoration-none text-success fw-semibold">
                                                        <i class="bi bi-arrow-right me-2"></i>{{ $article->title }}
                                                    </a>
                                                </li>
                                            @empty
                                                <li class="text-muted">No articles published yet.</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Legal -->
                            <div class="col-lg-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-warning text-dark">
                                        <h2 class="h5 mb-0"><i class="bi bi-shield-check me-2"></i>Legal &amp; Help</h2>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-3">
                                                <a href="{{ route('privacy-policy') }}" class="text-decoration-none fw-semibold text-warning"><i class="bi bi-arrow-right me-2"></i>Privacy Policy</a>
                                                <p class="small text-muted mb-0 ms-4">How we collect, use, and protect your data.</p>
                                            </li>
                                            <li class="mb-3">
                                                <a href="{{ route('terms-of-use') }}" class="text-decoration-none fw-semibold text-warning"><i class="bi bi-arrow-right me-2"></i>Terms of Service</a>
                                                <p class="small text-muted mb-0 ms-4">Terms and conditions for using DProperty.</p>
                                            </li>
                                            <li class="mb-3">
                                                <a href="{{ route('sitemap.xml') }}" class="text-decoration-none fw-semibold text-warning"><i class="bi bi-arrow-right me-2"></i>XML Sitemap (search engines)</a>
                                                <p class="small text-muted mb-0 ms-4">Machine-readable sitemap for crawlers.</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <footer class="border-top pt-4 mt-5">
                            <div class="text-center">
                                <p class="text-muted">This sitemap updates automatically as new properties, locations, and articles are published.</p>
                                <p class="small text-muted mb-0">Last updated: {{ now()->format('M Y') }}</p>
                            </div>
                        </footer>
                    </article>
                </div>
            </div>
        </div>
    </main>
@endsection
