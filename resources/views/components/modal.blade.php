@props([
    'id',
    'width',
    'location'
])

<div id={{$id}} class="modal" data-modal style="padding-top:{{$location}}%;">
    <div class="modal-content" style="width:{{$width}}%; ">
        {{$slot}}
    </div>
</div>