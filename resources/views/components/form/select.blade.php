@props(['label', 'name', 'placeholder' => 'Select Option', 'attr' => '', 'readonly' => false, 'required' => false, 'value' => '', 'customAttr' => ''])

<label class="info-label" for="{{ $name }}">
    {{ $label }}
    @if ($required)
        <span class="text-danger">*</span>
    @endif
</label>
<select name="{{ $name }}" id="{{ $name }}" {{ $attr }} required
    {{ $attributes->merge(['class' => 'form-select']) }} style="text-transform: uppercase;"
    {{ $readonly ? 'disabled' : '' }} {{ $required ? 'required' : '' }} {{ "{$customAttr}" }}
    select-value="{{ $value }}">
    <option value="" disabled>{{ $placeholder }}</option>
    {{ $slot }}
</select>
