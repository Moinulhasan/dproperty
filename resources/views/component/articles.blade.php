<style>
    /* On mobile the articles slider is auto-only — no nav buttons. */
    @media (max-width: 991px) {
        #articlesSlider .articles-slider-next,
        #articlesSlider .articles-slider-prev {
            display: none !important;
        }
    }
</style>
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
                                <img loading="lazy" src="{{ asset($article->image) }}" alt="{{ $article->title }}">
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

            {{-- Scoped nav classes so other swipers on the page can't hijack
                 these buttons (and vice-versa). --}}
            <div class="swiper-button-next articles-slider-next"></div>
            <div class="swiper-button-prev articles-slider-prev"></div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const el = document.getElementById('articlesSlider');
        if (!el) return;

        new Swiper(el, {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            watchOverflow: true,
            // Faster autoplay on mobile since the nav buttons are hidden.
            autoplay: {
                delay: window.innerWidth <= 991 ? 4000 : 7000,
                disableOnInteraction: false,
            },
            // Scope nav to THIS slider; otherwise Swiper picks up the first
            // .swiper-button-next in the DOM (which may be inside a card).
            navigation: {
                nextEl: el.querySelector('.articles-slider-next'),
                prevEl: el.querySelector('.articles-slider-prev'),
            },
            breakpoints: {
                640:  { slidesPerView: 2 },
                1024: { slidesPerView: 3 }
            }
        });
    });
</script>
@endpush
