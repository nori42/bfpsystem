@props(['label', 'value'])

<div class="col info-detail">
    <div class="fw-semibold" style="color:#7c7c7c;">{{ $label }}</div>
    <div class="fw-bold">{{ $value == null ? 'N/A' : $value }}</div>
</div>
