@php
    // Every access on $settings / $tags uses the null-safe operator so the
    // section renders cleanly on a brand-new install where the app_settings
    // row hasn't been created yet (and where $tags may be empty/missing).
    // Each value falls back to a sensible hardcoded default.

    $whyUsTitle = trim((string) ($settings?->why_us_title ?? '')) !== ''
        ? $settings->why_us_title
        : 'Why Choose Us?';

    $taglineFromTags = null;
    if (isset($tags) && $tags) {
        $taglineFromTags = optional($tags->where('service_type', 'why_us')->first())->tag_line;
    }
    $whyUsTagline = trim((string) ($settings?->why_us_tagline ?? '')) !== ''
        ? $settings->why_us_tagline
        : ($taglineFromTags
            ?: 'We are committed to delivering exceptional results that exceed your expectations.');

    $whyUsItems = $settings?->why_us_items ?? [];
    if (empty($whyUsItems)) {
        $whyUsItems = [
            ['title' => 'Expert Team',        'description' => 'Our experienced professionals bring years of industry expertise to every project.'],
            ['title' => 'Quality Assurance',  'description' => 'We maintain the highest standards of quality in all our deliverables.'],
            ['title' => '24/7 Support',       'description' => 'Round-the-clock support to ensure your business never stops running.'],
            ['title' => 'Competitive Pricing','description' => 'Affordable solutions without compromising on quality or service.'],
        ];
    }

    // contact_image is what's rendered as the section's hero image. If the
    // admin hasn't uploaded one yet, fall back to a public placeholder so
    // the layout isn't broken.
    $whyUsImage = $settings?->contact_image
        ?: asset('images/why_us.svg');
@endphp
<section id="about" class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <img src="{{ $whyUsImage }}" class="img-fluid rounded shadow mb-2" alt="{{ $whyUsTitle }}"
                     onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80';">
            </div>
            <div class="col-lg-6">
                <div class="ps-lg-4">
                    <h2 class="display-5 fw-bold text-primary mb-4">{{ $whyUsTitle }}</h2>
                    <p class="lead text-muted mb-4">{{ $whyUsTagline }}</p>

                    <div class="row g-3">
                        @foreach($whyUsItems as $item)
                            @php
                                $itemTitle = trim((string) ($item['title'] ?? ''));
                                $itemDesc  = trim((string) ($item['description'] ?? ''));
                            @endphp
                            @if($itemTitle !== '' || $itemDesc !== '')
                                <div class="col-12">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; min-width: 40px;">
                                            <i class="bi bi-check text-white"></i>
                                        </div>
                                        <div>
                                            @if($itemTitle !== '')
                                                <h6 class="fw-bold mb-1">{{ $itemTitle }}</h6>
                                            @endif
                                            @if($itemDesc !== '')
                                                <p class="text-muted mb-0">{{ $itemDesc }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
