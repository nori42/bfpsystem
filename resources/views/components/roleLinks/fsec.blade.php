<x-navLinks>
    @php
        $currentRoute = Route::currentRouteName();
    @endphp
    <x-navLinks.link href="/fsec" :active="$currentRoute == 'fsec'">
        <span class="material-symbols-outlined align-middle fs-2">
            domain
        </span>
        Building Plan
    </x-navLinks.link>

    <x-navLinks.link href="/reports/fsec" :active="$currentRoute == 'reports'">
        <span class="material-symbols-outlined align-middle fs-2">
            receipt_long
        </span>
        Reports
    </x-navLinks.link>
</x-navLinks>
