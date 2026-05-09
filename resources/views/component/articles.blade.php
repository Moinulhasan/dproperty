<section class="articles-section" id="articles">
    <div class="container-fluid px-md-5 px-3">
        <div class="section-header text-center">
            <h2 class="text-primary">Helpful Real Estate Articles</h2>
        </div>

        <div class="articles-slider swiper" id="articlesSlider">
            <div class="swiper-wrapper">
                @foreach($articles as $article)
                <div class="swiper-slide h-auto">
                    <div class="article-card">
                        <div class="article-image">
                            <span class="article-badge">{{ $article->meta_title ?? 'Real Estate' }}</span>
                            @if($article->image)
                                <img src="{{ asset($article->image) }}" alt="{{ $article->title }}">
                            @else
                                <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=800&q=80" alt="{{ $article->title }}">
                            @endif
                        </div>
                        <div class="article-content">
                            <div class="article-meta">
                                <span><i class="far fa-calendar-alt"></i> {{ $article->created_at->format('M d, Y') }}</span>
                                <span><i class="far fa-eye"></i> {{ $article->views }} Views</span>
                            </div>
                            <h3 class="article-title"><a href="{{ route('article-details', $article->slug) }}" class="text-decoration-none text-dark">{{ $article->title }}</a></h3>
                            <p class="article-excerpt">{{ Str::limit(strip_tags($article->content), 120) }}</p>
                            <a href="{{ route('article-details', $article->slug) }}" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Add Swiper Navigation -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const articlesSwiper = new Swiper('#articlesSlider', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 7000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                }
            }
        });
    });
</script>
@endpush
