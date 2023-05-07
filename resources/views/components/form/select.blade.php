@props(['label', 'name', 'placeholder' => 'Select Option', 'customAttr' => '', 'isDetail' => false, 'readonly' => false])

<label class="info-label" for="{{ $name }}">{{ $label }}</label>
<select name="{{ $name }}" id="{{ $name }}" required {{ $attributes->merge(['class' => 'form-select']) }}
    {{ $customAttr }} style="text-transform: uppercase;" {{ $readonly ? 'disabled' : '' }}>
    <option value="" disabled @if (!$isDetail) selected @endif>{{ $placeholder }}</option>
    {{ $slot }}
</select>
