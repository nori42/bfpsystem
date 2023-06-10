@props(['id', 'width', 'topLocation', 'leftLocation' => '30'])

<div id={{ $id }} class="modal" data-modal style="padding-top:{{ $topLocation }}%;">
    <div class="modal-content" style="width:{{ $width }}%;  margin-left: calc({{ $leftLocation }}%);">
        {{ $slot }}
    </div>
</div>
