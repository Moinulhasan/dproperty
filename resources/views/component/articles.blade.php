<section class="articles-section">
    <div class="container-fluid px-md-5 px-3">
        <div class="section-header text-center">
            <h2 class="text-primary">Helpful Real Estate Articles</h2>
            <p>Stay updated with the latest trends and tips in real estate</p>
        </div>

        <div class="articles-slider swiper" id="articlesSlider">
            <div class="swiper-wrapper">
                <!-- Article 1 -->
                <div class="swiper-slide h-auto">
                    <div class="article-card">
                        <div class="article-image">
                            <span class="article-badge">Buying Tips</span>
                            <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=800&q=80" alt="Article 1">
                        </div>
                        <div class="article-content">
                            <div class="article-meta">
                                <span><i class="far fa-calendar-alt"></i> Oct 24, 2023</span>
                                <span><i class="far fa-user"></i> Admin</span>
                            </div>
                            <h3 class="article-title">10 Important Things to Know Before Buying a Home</h3>
                            <p class="article-excerpt">Buying a home is one of the biggest investments you'll ever make. Here are the key factors you should consider...</p>
                            <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Article 2 -->
                <div class="swiper-slide h-auto">
                    <div class="article-card">
                        <div class="article-image">
                            <span class="article-badge">Market Trends</span>
                            <img src="https://images.unsplash.com/photo-1460472178825-e5240623abe5?auto=format&fit=crop&w=800&q=80" alt="Article 2">
                        </div>
                        <div class="article-content">
                            <div class="article-meta">
                                <span><i class="far fa-calendar-alt"></i> Oct 20, 2023</span>
                                <span><i class="far fa-user"></i> Editor</span>
                            </div>
                            <h3 class="article-title">The Future of Real Estate: Trends to Watch in 2024</h3>
                            <p class="article-excerpt">As we approach the new year, several emerging trends are set to reshape the property market landscape...</p>
                            <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Article 3 -->
                <div class="swiper-slide h-auto">
                    <div class="article-card">
                        <div class="article-image">
                            <span class="article-badge">Interior Design</span>
                            <img src="https://images.unsplash.com/photo-1484154218962-a197022b5858?auto=format&fit=crop&w=800&q=80" alt="Article 3">
                        </div>
                        <div class="article-content">
                            <div class="article-meta">
                                <span><i class="far fa-calendar-alt"></i> Oct 15, 2023</span>
                                <span><i class="far fa-user"></i> Admin</span>
                            </div>
                            <h3 class="article-title">How to Maximize Your Space in a Small Apartment</h3>
                            <p class="article-excerpt">Living in a compact space doesn't mean compromising on style or functionality. Discover our top tips for...</p>
                            <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Article 4 -->
                <div class="swiper-slide h-auto">
                    <div class="article-card">
                        <div class="article-image">
                            <span class="article-badge">Investment</span>
                            <img src="https://images.unsplash.com/photo-1554469384-e58fac16e23a?auto=format&fit=crop&w=800&q=80" alt="Article 4">
                        </div>
                        <div class="article-content">
                            <div class="article-meta">
                                <span><i class="far fa-calendar-alt"></i> Oct 10, 2023</span>
                                <span><i class="far fa-user"></i> Editor</span>
                            </div>
                            <h3 class="article-title">Why Real Estate is Still the Best Long-Term Investment</h3>
                            <p class="article-excerpt">Compared to other asset classes, real estate offers unique advantages for building long-term wealth...</p>
                            <a href="#" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
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
