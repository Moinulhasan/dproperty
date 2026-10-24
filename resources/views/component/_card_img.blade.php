{{-- Card slider image. $src: public path or asset() URL; optional $class, $style, $title.
     $deferred: wrap in an inert <template> (no request, no DOM node) until the card is
     first hovered/touched/focused — see the hydrate handler in include/script.blade.php. --}}
@if(!empty($deferred))<template>@endif<img src="{{ thumb($src) }}"
     srcset="{{ thumb($src, 480) }} 480w, {{ thumb($src, 960) }} 960w"
     sizes="(max-width:768px) 100vw, 437px"
     width="437" height="240" loading="lazy" decoding="async"
     alt="{{ $alt }}"@isset($title) title="{{ $title }}"@endisset @isset($class) class="{{ $class }}"@endisset @isset($style) style="{{ $style }}"@endisset>@if(!empty($deferred))</template>@endif
