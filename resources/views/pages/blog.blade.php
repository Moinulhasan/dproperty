@extends('master')

@section('title', 'Expert Real Estate Insights & News | DProperty Blog')
@section('meta_description', 'Discover the latest trends, expert tips, and comprehensive guides on real estate in Bangladesh. Stay informed with DProperty.')

@section('seo')
    @include('component._breadcrumb_jsonld', ['crumbs' => [
        ['name' => 'Home', 'url' => route('home')],
        ['name' => 'Blog', 'url' => route('blog')],
    ]])
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/articles.css') }}">
<style>
    .articles-grid {
        padding: 40px 0 80px;
        background-color: #fdfdfd;
    }

    .pagination-wrapper {
        margin-top: 50px;
    }

    .pagination .page-link {
        border-radius: 10px;
        margin: 0 5px;
        color: #444;
        font-weight: 600;
        border: 1px solid #eee;
        padding: 10px 18px;
        transition: all 0.3s ease;
    }

    .pagination .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: #fff;
        box-shadow: 0 5px 15px rgba(0, 106, 80, 0.3);
    }

    .pagination .page-link:hover:not(.active) {
        background-color: #f8f9fa;
        color: var(--primary-color);
    }
</style>
@endsection

@section('content')
<div class="service-page-hero">
    <div class="container px-md-5 px-3">
        <nav aria-label="breadcrumb" class="breadcrumb-listing mb-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Blog</li>
            </ol>
        </nav>
        <h1>Our Blog</h1>
        <p class="mb-0 text-white-50">Insights, trends, and expert advice to help you navigate the real estate market with confidence.</p>
    </div>
</div>

<!-- Articles Grid -->
<section class="articles-grid">
    <div class="container px-md-5 px-3">
        <div class="row g-4">
            @forelse($articles as $article)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="article-card shadow-sm border-0 h-100">
                    <div class="article-image">
                        <span class="article-badge">{{ $article->meta_title ?? 'Real Estate' }}</span>
                        <a href="{{ route('article-details', $article->slug) }}">
                            @if($article->image)
                                <img loading="lazy" src="{{ asset($article->image) }}" alt="{{ $article->title }}" class="img-fluid">
                            @else
                                <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=800&q=80" alt="{{ $article->title }}" class="img-fluid">
                            @endif
                        </a>
                    </div>
                    <div class="article-content p-4">
                        <div class="article-meta mb-2">
                            <span><i class="far fa-calendar-alt me-1"></i> {{ $article->created_at->format('M d, Y') }}</span>
                            <span class="ms-3"><i class="far fa-eye me-1"></i> {{ $article->views }} Views</span>
                        </div>
                        <h3 class="article-title mb-3">
                            <a href="{{ route('article-details', $article->slug) }}" class="text-decoration-none text-dark hover-primary">{{ $article->title }}</a>
                        </h3>
                        <p class="article-excerpt text-muted small mb-4">
                            {{ Str::limit(strip_tags($article->content), 120) }}
                        </p>
                        <a href="{{ route('article-details', $article->slug) }}" class="read-more fw-bold text-primary text-decoration-none">
                            Read Full Article <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="no-articles-found">
                    <i class="fas fa-newspaper fa-4x text-light mb-4"></i>
                    <h3 class="text-muted">No articles found at the moment.</h3>
                    <p class="text-muted">Please check back later for fresh real estate insights.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary mt-3 px-4 rounded-pill">Back to Home</a>
                </div>
            </div>
            @endforelse
        </div>

        @if($articles->hasPages())
        <div class="pagination-wrapper d-flex justify-content-center">
            {{ $articles->links() }}
        </div>
        @endif
    </div>
</section>
@endsection
