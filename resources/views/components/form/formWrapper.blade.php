@props(['action' => '', 'method' => ''])

<form class="form-wrapper boxshadow" action="{{ $action }}" method="{{ $method }}">
    {{ $slot }}
</form>
