@props(['label', 'name', 'placeholder' => 'Select Option', 'customAttr' => '', 'isDetail' => false, 'readonly' => false, 'required' => false])

<label class="info-label" for="{{ $name }}">
    {{ $label }}
    @if ($required)
        <span class="text-danger">*</span>
    @endif
</label>
<select name="{{ $name }}" id="{{ $name }}" required {{ $attributes->merge(['class' => 'form-select']) }}
    {{ $customAttr }} style="text-transform: uppercase;" {{ $readonly ? 'disabled' : '' }}
    {{ $required ? 'required' : '' }}>
    <option value="" disabled @if (!$isDetail) selected @endif>{{ $placeholder }}</option>
    {{ $slot }}
</select>
