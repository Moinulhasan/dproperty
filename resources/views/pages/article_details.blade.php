@extends('master')

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
            <div class="col-lg-8">
                <article class="article-main bg-white rounded-4 shadow-sm overflow-hidden">
                    <div class="article-header position-relative">
                        <img src="{{ $article->image }}" alt="{{ $article->title }}" class="img-fluid w-100" style="height: 450px; object-fit: cover;">
                        <span class="position-absolute bottom-0 start-0 m-4 badge bg-primary px-3 py-2 fs-6">{{ $article->category }}</span>
                    </div>
                    
                    <div class="article-body p-4 p-md-5">
                        <div class="article-meta d-flex align-items-center mb-4 text-muted gap-4">
                            <span><i class="far fa-calendar-alt me-2 text-primary"></i> {{ $article->date }}</span>
                            <span><i class="far fa-user me-2 text-primary"></i> {{ $article->author }}</span>
                        </div>

                        <h1 class="article-title display-5 fw-bold mb-4">{{ $article->title }}</h1>
                        
                        <div class="article-content fs-5 text-secondary lh-lg">
                            {!! nl2br(e($article->content)) !!}
                        </div>

                        <hr class="my-5">

                        <div class="article-footer d-flex justify-content-between align-items-center">
                            <div class="share-article">
                                <span class="fw-bold me-3 text-primary">Share:</span>
                                <a href="#" class="btn btn-outline-primary btn-sm rounded-circle me-2"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="btn btn-outline-primary btn-sm rounded-circle me-2"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="btn btn-outline-primary btn-sm rounded-circle me-2"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                            <a href="{{ route('home') }}" class="btn btn-primary px-4 py-2 rounded-pill"><i class="fas fa-arrow-left me-2"></i> Back to Home</a>
                        </div>
                    </div>
                </article>
            </div>

            <div class="col-lg-4">
                <aside class="article-sidebar mt-4 mt-lg-0">
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-4 text-primary"><i class="fas fa-newspaper me-2"></i> Recent Articles</h4>
                            @foreach($articles as $a_slug => $a_data)
                                <div class="recent-article-item d-flex gap-3 mb-4">
                                    <img src="{{ $a_data['image'] }}" alt="{{ $a_data['title'] }}" class="rounded-3" style="width: 80px; height: 80px; object-fit: cover;">
                                    <div>
                                        <h6 class="fw-bold mb-1">
                                            <a href="{{ route('article-details', $a_slug) }}" class="text-decoration-none text-dark hover-primary">{{ Str::limit($a_data['title'], 40) }}</a>
                                        </h6>
                                        <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> {{ $a_data['date'] }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 bg-primary text-white p-4">
                        <h4 class="fw-bold mb-3">Newsletter</h4>
                        <p class="mb-4 opacity-75">Subscribe to our newsletter to get latest real estate tips and tricks.</p>
                        <form>
                            <div class="mb-3">
                                <input type="email" class="form-control border-0 py-2 px-3" placeholder="Enter your email">
                            </div>
                            <button class="btn btn-light text-primary fw-bold w-100 rounded-pill py-2">Subscribe Now</button>
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
        padding: 1rem 1.5rem;
        background: #f1f8ff;
        font-style: italic;
        margin: 2rem 0;
    }
    .article-content strong {
        color: #333;
    }
    .breadcrumb-item.active {
        color: var(--bs-primary);
        font-weight: 500;
    }
</style>
@endsection
