@props(['label', 'type' => 'text', 'name', 'customAttr' => ''])
<x-form.inputWrapper>
    <label class="info-label">{{ $label }}</label>
    <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value=""
        {{ $attributes->merge(['class' => 'form-control']) }} {{ $customAttr }} required>
</x-form.inputWrapper>
