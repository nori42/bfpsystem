@props(['label', 'tooltiptext', 'color'])
<div
    class="{{ $color == 'danger' ? 'text-danger' : 'text-warning' }} d-inline fs-2 fw-bolder user-select-none px-3 tooltip-nb">
    {{ $label }} <span class="tooltiptext-nb fs-6 fw-normal">{{ $tooltiptext }}</span>
</div>
