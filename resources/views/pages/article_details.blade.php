@extends('master')

@section('title', ($article->meta_title ?? $article->title) . ' | DProperty')
@section('meta_description', $article->meta_description ?? Str::limit(strip_tags($article->content), 160))

@section('seo')
    <meta property="og:title" content="{{ $article->title }}" />
    <meta property="og:description" content="{{ $article->meta_description ?? Str::limit(strip_tags($article->content), 160) }}" />
    @if($article->image)
    <meta property="og:image" content="{{ asset($article->image) }}" />
    @endif
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta name="twitter:card" content="summary_large_image">

    @include('component._breadcrumb_jsonld', ['crumbs' => [
        ['name' => 'Home',           'url' => route('home')],
        ['name' => 'Blog',           'url' => route('blog')],
        ['name' => $article->title,  'url' => url()->current()],
    ]])

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Article",
        "headline": "{{ addslashes($article->title) }}",
        "datePublished": "{{ $article->created_at->toAtomString() }}",
        "dateModified": "{{ $article->updated_at->toAtomString() }}",
        @if($article->image)
        "image": ["{{ asset($article->image) }}"],
        @endif
        "mainEntityOfPage": "{{ url()->current() }}",
        "publisher": {
            "@type": "Organization",
            "name": "DProperty",
            "logo": { "@type": "ImageObject", "url": "{{ asset(($settings->logo ?? 'images/logo_main.png')) }}" }
        }
    }
    </script>
@endsection

@section('content')
<div class="article-details-page py-5 mt-5">
    <div class="container px-md-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Articles</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $article->title }}</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <article class="article-main bg-white rounded-4 shadow-sm overflow-hidden border">
                    <div class="article-header position-relative">
                        @if($article->image)
                            <img src="{{ asset($article->image) }}" alt="{{ $article->title }}" class="img-fluid w-100" style="height: 450px; object-fit: cover;">
                        @else
                            <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=1200&q=80" alt="{{ $article->title }}" class="img-fluid w-100" style="height: 450px; object-fit: cover;">
                        @endif
                        <span class="position-absolute bottom-0 start-0 m-4 badge bg-primary px-3 py-2 fs-6">{{ $article->meta_title ?? 'Real Estate' }}</span>
                    </div>
                    
                    <div class="article-body p-4 p-md-5">
                        <div class="article-meta d-flex align-items-center mb-4 text-muted gap-4 flex-wrap">
                            <span class="d-flex align-items-center"><i class="bi bi-calendar3 me-2 text-primary"></i> {{ $article->created_at->format('M d, Y') }}</span>
                            <span class="d-flex align-items-center"><i class="bi bi-eye me-2 text-primary"></i> {{ $article->views }} Views</span>
                            <span class="d-flex align-items-center"><i class="bi bi-clock me-2 text-primary"></i> {{ ceil(str_word_count(strip_tags($article->content)) / 200) }} min read</span>
                        </div>

                        <h1 class="article-title display-5 fw-bold mb-4">{{ $article->title }}</h1>
                        
                        <div class="article-content fs-5 text-secondary lh-lg">
                            {!! $article->content !!}
                        </div>

                        <hr class="my-5">

                        <div class="article-footer d-flex flex-wrap justify-content-between align-items-center gap-4 py-4 border-top border-bottom my-5">
                            <div class="share-article d-flex align-items-center">
                                <span class="fw-bold me-3 text-dark">Share this article:</span>
                                <div class="share-buttons d-flex gap-2">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="share-btn facebook" title="Share on Facebook"><i class="fab fa-facebook-f"></i></a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" target="_blank" class="share-btn twitter" title="Share on Twitter"><i class="fab fa-twitter"></i></a>
                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}" target="_blank" class="share-btn linkedin" title="Share on LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                                    <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . url()->current()) }}" target="_blank" class="share-btn whatsapp" title="Share on WhatsApp"><i class="fab fa-whatsapp"></i></a>
                                </div>
                            </div>
                            <div class="article-navigation">
                                <a href="{{ route('home') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm hover-up">
                                    <i class="bi bi-house-door me-2"></i> Back to Home
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <aside class="article-sidebar mt-4 mt-lg-0">
                    <div class="accordion modern-sidebar-accordion" id="sidebarAccordion">
                        <!-- Recent Articles Widget -->
                        <div class="accordion-item border-0 shadow-sm rounded-4 mb-4 overflow-hidden border">
                            <h2 class="accordion-header d-lg-none" id="headingRecent">
                                <button class="accordion-button fw-bold text-primary py-3 px-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRecent" aria-expanded="true" aria-controls="collapseRecent">
                                    <i class="bi bi-newspaper me-2"></i> Recent Articles
                                </button>
                            </h2>
                            <div id="collapseRecent" class="accordion-collapse collapse show" aria-labelledby="headingRecent" data-bs-parent="#sidebarAccordion">
                                <div class="accordion-body p-4">
                                    <h4 class="fw-bold mb-4 text-primary d-none d-lg-block"><i class="bi bi-newspaper me-2"></i> Recent Articles</h4>
                                    @foreach($recent_articles as $recent)
                                        <div class="recent-article-item d-flex gap-3 mb-4">
                                            <div class="flex-shrink-0">
                                                @if($recent->image)
                                                    <img loading="lazy" src="{{ asset($recent->image) }}" alt="{{ $recent->title }}" class="rounded-3 shadow-sm" style="width: 70px; height: 70px; object-fit: cover;">
                                                @else
                                                    <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=800&q=80" alt="{{ $recent->title }}" class="rounded-3 shadow-sm" style="width: 70px; height: 70px; object-fit: cover;">
                                                @endif
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="fw-bold mb-1 lh-base" style="font-size: 0.95rem;">
                                                    <a href="{{ route('article-details', $recent->slug) }}" class="text-decoration-none text-dark hover-primary line-clamp-2">{{ $recent->title }}</a>
                                                </h6>
                                                <small class="text-muted"><i class="bi bi-calendar3 me-1"></i> {{ $recent->created_at->format('M d, Y') }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Newsletter Widget -->
                        <div class="accordion-item border-0 shadow-sm rounded-4 bg-primary text-white overflow-hidden">
                            <h2 class="accordion-header d-lg-none" id="headingNewsletter">
                                <button class="accordion-button collapsed fw-bold text-white bg-primary py-3 px-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNewsletter" aria-expanded="false" aria-controls="collapseNewsletter" style="box-shadow: none;">
                                    <i class="bi bi-envelope-paper me-2"></i> Newsletter
                                </button>
                            </h2>
                            <div id="collapseNewsletter" class="accordion-collapse collapse show d-lg-block" aria-labelledby="headingNewsletter">
                                <div class="accordion-body p-4">
                                    <h4 class="fw-bold mb-3 d-none d-lg-block">Newsletter</h4>
                                    <p class="mb-4 opacity-75 small">Subscribe to our newsletter for the latest real estate trends and market insights.</p>
                                    <form action="#" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <div class="input-group">
                                                <span class="input-group-text border-0 bg-white text-muted"><i class="bi bi-envelope"></i></span>
                                                <input type="email" class="form-control border-0 py-2" placeholder="Your email address" required>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-light text-primary fw-bold w-100 rounded-pill py-2 shadow-sm transition-all hover-up">Subscribe Now</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>

<style>
    .article-details-page {
        background-color: #fdfdfd;
        font-family: 'Inter', sans-serif;
    }
    
    .article-main {
        border: 1px solid #f0f0f0 !important;
        box-shadow: 0 15px 45px rgba(0,0,0,0.03) !important;
    }

    .article-content {
        color: #374151;
        line-height: 1.8;
        font-size: 1.15rem;
    }

    .article-content p {
        margin-bottom: 1.8rem;
    }

    .article-content blockquote {
        border-left: 6px solid var(--primary-color);
        padding: 2rem 2.5rem;
        background: #f8fafc;
        font-style: italic;
        margin: 3rem 0;
        border-radius: 0 16px 16px 0;
        color: #1f2937;
        font-size: 1.25rem;
        position: relative;
    }

    .article-content blockquote::before {
        content: '"';
        position: absolute;
        top: 10px;
        left: 10px;
        font-size: 4rem;
        color: var(--primary-color);
        opacity: 0.1;
        font-family: serif;
    }

    .article-content img {
        border-radius: 16px;
        margin: 2rem 0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        max-width: 100%;
    }

    /* Premium Breadcrumb - Matching Property Details */
    .breadcrumb {
        background: #fff;
        padding: 8px 20px;
        border-radius: 50px;
        display: inline-flex;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid #f0f0f0;
        margin-bottom: 0;
    }

    .breadcrumb-item {
        font-size: 0.85rem;
        font-weight: 500;
        display: flex;
        align-items: center;
    }

    .breadcrumb-item a {
        color: var(--primary-color);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .breadcrumb-item a:hover {
        color: #111;
    }

    .breadcrumb-item.active {
        color: #888;
        font-weight: 500;
    }

    .breadcrumb-item+.breadcrumb-item::before {
        content: "\F285"; /* Bootstrap Icons chevron-right */
        font-family: "bootstrap-icons";
        font-weight: 900;
        color: #ccc;
        font-size: 0.75rem;
        margin-top: 2px;
    }

    .article-content h2, .article-content h3 {
        color: #111827;
        font-weight: 800;
        margin-top: 3rem;
        margin-bottom: 1.5rem;
        letter-spacing: -0.025em;
    }

    /* Share Buttons Styles */
    .share-btn {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        text-decoration: none !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 1rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .share-btn.facebook { background-color: #1877f2; }
    .share-btn.twitter { background-color: #1da1f2; }
    .share-btn.linkedin { background-color: #0a66c2; }
    .share-btn.whatsapp { background-color: #25d366; }

    .share-btn:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        color: #fff;
        filter: brightness(1.1);
    }

    .hover-up {
        transition: all 0.3s ease;
    }
    .hover-up:hover {
        transform: translateY(-3px);
    }

    /* Accordion Customization */
    .modern-sidebar-accordion .accordion-button:not(.collapsed) {
        background-color: transparent;
        color: var(--primary-color);
        box-shadow: none;
    }
    
    .modern-sidebar-accordion .accordion-button::after {
        background-size: 1rem;
    }

    .modern-sidebar-accordion .accordion-item {
        border: 1px solid #f0f0f0 !important;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .hover-primary:hover {
        color: var(--primary-color) !important;
    }

    @media (max-width: 991px) {
        .article-content {
            font-size: 1.05rem;
        }
        .accordion-collapse.collapse:not(.show) {
            display: none;
        }
        .d-lg-block {
            display: none !important;
        }
    }
</style>
@endsection

