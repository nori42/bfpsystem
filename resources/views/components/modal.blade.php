@props(['id', 'width' => '120', 'topLocation' => '10', 'leftLocation' => '30', 'class' => ''])

<div id={{ $id }} class="modal" data-modal style="padding-top:{{ $topLocation }}%;">
    <div class="modal-content {{ $class }}"
        style="width:{{ $width }}%;  margin-left: calc({{ $leftLocation }}%);">
        {{ $slot }}
    </div>
</div>
