@props(['href', 'active' => false])

<li class="m-2">
    <a class="btn w-100 text-start text-white {{ $active ? 'link-active' : '' }}" href="{{ $href }}">
        {{ $slot }}
    </a>
</li>
