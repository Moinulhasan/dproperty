{{-- Expects $crumbs as an array of ['name' => 'X', 'url' => 'https://...'] in order. --}}
@php
    $items = [];
    foreach ($crumbs as $i => $c) {
        $items[] = [
            '@type' => 'ListItem',
            'position' => $i + 1,
            'name' => $c['name'],
            'item' => $c['url'],
        ];
    }
    $payload = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $items,
    ];
@endphp
<script type="application/ld+json">{!! json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
