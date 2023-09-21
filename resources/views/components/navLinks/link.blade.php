@props(['href', 'active' => false])

<li class="mx-1 mt-3" style="height: 40px;">
    <a class="btn w-100 text-start text-white {{ $active ? 'link-active' : '' }}" href="{{ $href }}">
        {{ $slot }}
    </a>
</li>
