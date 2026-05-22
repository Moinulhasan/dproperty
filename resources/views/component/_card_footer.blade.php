@php $summary = $p->cardSummary(); @endphp
<div class="card-footer-global">
    <div class="feature-item-global"><i class="{{ $summary['bedrooms']['icon'] }}"></i> {{ $summary['bedrooms']['value'] ?? '-' }} {{ $summary['bedrooms']['label'] }}</div>
    <div class="feature-item-global"><i class="{{ $summary['bathrooms']['icon'] }}"></i> {{ $summary['bathrooms']['value'] ?? '-' }} {{ $summary['bathrooms']['label'] }}</div>
    <div class="feature-item-global"><i class="{{ $summary['area']['icon'] }}"></i> {{ $summary['area']['value'] ?? '-' }} {{ $summary['area']['label'] }}</div>
</div>
