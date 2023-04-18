@props(['id', 'width', 'topLocation'])

<div id={{ $id }} class="modal" data-modal style="padding-top:{{ $topLocation }}%;">
    <div class="modal-content" style="width:{{ $width }}%; ">
        {{ $slot }}
    </div>
</div>
