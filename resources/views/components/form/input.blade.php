@props(['label', 'type' => 'text', 'name', 'customAttr' => '', 'value' => '', 'readonly' => false, 'required' => false])
<x-form.inputWrapper>
    <label class="info-label">{{ $label }}</label>
    <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value="{{ $value }}"
        {{ $attributes->merge(['class' => 'form-control']) }} {{ $customAttr }} {{ $readonly ? 'readonly' : '' }}
        {{ $required ? 'readonly' : '' }}>
</x-form.inputWrapper>
