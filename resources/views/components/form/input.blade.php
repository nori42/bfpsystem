@props(['label', 'type' => 'text', 'name', 'customAttr' => '', 'value' => '', 'readonly' => false, 'required' => false])
<x-form.inputWrapper>
    <label class="info-label">{{ $label }}</label>
    <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value="{{ $value }}"
        {{ $attributes->merge(['class' => 'form-control text-uppercase']) }} {{ $customAttr }}
        {{ $readonly ? 'readonly' : '' }} {{ $required ? 'required' : '' }} autocomplete="off">
</x-form.inputWrapper>
