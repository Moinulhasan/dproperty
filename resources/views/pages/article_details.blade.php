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
                        <div class="article-meta d-flex align-items-center mb-4 text-muted gap-4">
                            <span><i class="far fa-calendar-alt me-2 text-primary"></i> {{ $article->created_at->format('M d, Y') }}</span>
                            <span><i class="far fa-eye me-2 text-primary"></i> {{ $article->views }} Views</span>
                        </div>

                        <h1 class="article-title display-5 fw-bold mb-4">{{ $article->title }}</h1>
                        
                        <div class="article-content fs-5 text-secondary lh-lg">
                            {!! $article->content !!}
                        </div>

                        <hr class="my-5">

                        <div class="article-footer d-flex flex-wrap justify-content-between align-items-center gap-3">
                            <div class="share-article d-flex align-items-center">
                                <span class="fw-bold me-3 text-primary">Share:</span>
                                <div class="share-buttons">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-circle me-2"><i class="fab fa-facebook-f"></i></a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-circle me-2"><i class="fab fa-twitter"></i></a>
                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-circle me-2"><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                            <a href="{{ route('home') }}" class="btn btn-primary px-4 py-2 rounded-pill"><i class="fas fa-arrow-left me-2"></i> Back to Home</a>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <aside class="article-sidebar mt-4 mt-lg-0">
                    <div class="card border-0 shadow-sm rounded-4 mb-4 border">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-4 text-primary"><i class="fas fa-newspaper me-2"></i> Recent Articles</h4>
                            @foreach($recent_articles as $recent)
                                <div class="recent-article-item d-flex gap-3 mb-4">
                                    <div class="flex-shrink-0">
                                        @if($recent->image)
                                            <img src="{{ asset($recent->image) }}" alt="{{ $recent->title }}" class="rounded-3" style="width: 80px; height: 80px; object-fit: cover;">
                                        @else
                                            <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=800&q=80" alt="{{ $recent->title }}" class="rounded-3" style="width: 80px; height: 80px; object-fit: cover;">
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">
                                            <a href="{{ route('article-details', $recent->slug) }}" class="text-decoration-none text-dark hover-primary line-clamp-2">{{ $recent->title }}</a>
                                        </h6>
                                        <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> {{ $recent->created_at->format('M d, Y') }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 bg-primary text-white p-4">
                        <h4 class="fw-bold mb-3">Newsletter</h4>
                        <p class="mb-4 opacity-75">Subscribe to our newsletter to get latest real estate tips and tricks.</p>
                        <form action="#" method="POST">
                            @csrf
                            <div class="mb-3">
                                <input type="email" class="form-control border-0 py-2 px-3" placeholder="Enter your email" required>
                            </div>
                            <button type="submit" class="btn btn-light text-primary fw-bold w-100 rounded-pill py-2">Subscribe Now</button>
                        </form>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>

<style>
    .article-details-page {
        background-color: #f8f9fa;
    }
    .hover-primary:hover {
        color: var(--bs-primary) !important;
    }
    .article-content blockquote {
        border-left: 5px solid var(--bs-primary);
        padding: 1.5rem 2rem;
        background: #f1f8ff;
        font-style: italic;
        margin: 2.5rem 0;
        border-radius: 0 12px 12px 0;
    }
    .article-content h2, .article-content h3 {
        color: #222;
        font-weight: 700;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
    .article-content p {
        margin-bottom: 1.5rem;
    }
    .breadcrumb-item.active {
        color: var(--bs-primary);
        font-weight: 500;
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .article-body {
        color: #444;
    }
    .article-main {
        border: 1px solid #efefef !important;
    }
</style>
@endsection

