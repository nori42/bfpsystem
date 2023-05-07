@props(['label'])

<div class="my-5">
    <h3 class="fw-semibold">{{ $label }}</h3>
    <hr>
    <div class="d-flex flex-wrap gap-5">
        {{ $slot }}
    </div>
</div>
