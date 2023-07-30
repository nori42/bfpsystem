<x-navLinks>
    @php
        $currentRoute = Route::currentRouteName();
    @endphp
    <x-navLinks.link href="/dashboard" :active="$currentRoute == 'dashboard'">
        <!-- button Icon -->
        <span class="material-symbols-outlined align-middle fs-2">
            dashboard
        </span>
        Dashboard
    </x-navLinks.link>

    <x-navLinks.link href="/establishments" :active="$currentRoute == 'establishments'">
        <!-- button Icon -->
        <span class="material-symbols-outlined align-middle fs-2">
            domain
        </span>
        Establishments
    </x-navLinks.link>

    <x-navLinks.link href="/fsec" :active="$currentRoute == 'fsec'">
        <!-- button Icon -->
        <span class="material-symbols-outlined align-middle fs-2">
            corporate_fare
        </span>
        Building Plan
    </x-navLinks.link>

    <x-navLinks.link href="/personnel" :active="$currentRoute == 'personnel'">
        <!-- button Icon -->
        <span class="material-symbols-outlined align-middle fs-2">
            group
        </span>
        Personnel
    </x-navLinks.link>

    <x-navLinks.link href="/users" :active="$currentRoute == 'users'">
        <!-- button Icon -->
        <span class="material-symbols-outlined align-middle fs-2">
            account_box
        </span>
        Users
    </x-navLinks.link>

    <x-navLinks.link href="/reports/fsic" :active="$currentRoute == 'reports'">
        <!-- button Icon -->
        <span class="material-symbols-outlined align-middle fs-2">
            receipt_long
        </span>
        Reports
    </x-navLinks.link>

    <x-navLinks.link href="/activity" :active="$currentRoute == 'activity'">
        <!-- button Icon -->
        <span class="material-symbols-outlined align-middle fs-2">
            event_note
        </span>
        Activity Log
    </x-navLinks.link>

    {{-- <x-navLinks.link href="/archived" :active="$currentRoute == 'archived'">
        <!-- button Icon -->
        <span class="material-symbols-outlined align-middle fs-2">
            dresser
        </span>
        Archive
    </x-navLinks.link> --}}
</x-navLinks>
