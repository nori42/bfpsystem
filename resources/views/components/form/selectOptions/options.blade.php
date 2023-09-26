@props(['options', 'selected' => ''])

@foreach ($options as $option)
    <option value="{{ $option }}" @if ($selected === $option) selected @endif>{{ $option }}</option>
@endforeach
