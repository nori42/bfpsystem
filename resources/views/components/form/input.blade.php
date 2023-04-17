@props([
    'label',
    'type' => 'text',
    'name',
])

<div class="my-2">
    <label class="info-label">{{$label}}</label>
    <input type="{{$type}}" id="{{$name}}" name="{{$name}}" value="" class="input" data-owner-input required>
</div>