@props(['label', 'name', 'placeholder' => 'Select Option', 'customAttr' => ''])

<label class="info-label" for="{{ $name }}">{{ $label }}</label>
<select name="{{ $name }}" id="{{ $name }}" required class="form-control" {{ $customAttr }}>
    <option value="" disabled selected>{{ $placeholder }}</option>
</select>
