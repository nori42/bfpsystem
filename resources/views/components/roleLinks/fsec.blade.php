<x-navLinks>
    @php
        $currentRoute = Route::currentRouteName();
    @endphp
    <x-navLinks.link href="/fsec" :active="$currentRoute == 'fsec'">
        {{-- <!-- button Icon -->
        <span class="material-symbols-outlined align-middle fs-2">
            corporate_fare
        </span> --}}
        <i class="bi bi-building-fill align-middle mr-4"></i>
        <span class="fs-6">Building Plan</span>
    </x-navLinks.link>

    <x-navLinks.link href="/reports/fsec" :active="$currentRoute == 'reports'">
        <!-- button Icon -->
        {{-- <span class="material-symbols-outlined align-middle fs-2">
            receipt_long
        </span> --}}
        <i class="bi bi-file-text-fill align-middle mr-4"></i>
        <span class="fs-6">Reports</span>
    </x-navLinks.link>
</x-navLinks>
