<x-navLinks>
    @php
        $currentRoute = Route::currentRouteName();
    @endphp
    <x-navLinks.link href="/dashboard" :active="$currentRoute == 'dashboard'">
        <!-- button Icon -->
        {{-- <span class="material-symbols-outlined align-middle fs-2">
            dashboard
        </span> --}}
        <i class="bi bi-microsoft align-middle mr-4"></i>
        <span class="fs-6">Dashboard</span>
    </x-navLinks.link>

    <x-navLinks.link href="/establishments" :active="$currentRoute == 'establishments'">
        <!-- button Icon -->
        <i class="bi bi-building-fill align-middle mr-4"></i>
        <span class="fs-6">Establishments</span>
    </x-navLinks.link>

    <x-navLinks.link href="/fsec" :active="$currentRoute == 'fsec'">
        {{-- <!-- button Icon -->
        <span class="material-symbols-outlined align-middle fs-2">
            corporate_fare
        </span> --}}
        <div class="d-inline mr-4">
            <i class="bi bi-building-fill align-middle"></i>
            <i class="bi bi-file-earmark-medical-fill"
                style="position: absolute; left: 25px; bottom: 0px; font-size: 1.3rem !important;"></i>
        </div>
        <span class="fs-6">Building Plan</span>
    </x-navLinks.link>

    <x-navLinks.link href="/personnel" :active="$currentRoute == 'personnel'">
        <!-- button Icon -->
        {{-- <span class="material-symbols-outlined align-middle fs-2">
            group
        </span> --}}
        <i class="bi bi-people-fill align-middle mr-4"></i>
        <span class="fs-6">Personnel</span>

    </x-navLinks.link>

    <x-navLinks.link href="/users" :active="$currentRoute == 'users'">
        <!-- button Icon -->
        {{-- <span class="material-symbols-outlined align-middle fs-2">
            account_box
        </span> --}}
        <i class="bi bi-person-fill align-middle mr-4"></i>
        <span class="fs-6">Users</span>
    </x-navLinks.link>

    <x-navLinks.link href="/reports/fsic" :active="$currentRoute == 'reports'">
        <!-- button Icon -->
        {{-- <span class="material-symbols-outlined align-middle fs-2">
            receipt_long
        </span> --}}
        <i class="bi bi-file-text-fill align-middle mr-4"></i>
        <span class="fs-6">Reports</span>
    </x-navLinks.link>

    <x-navLinks.link href="/activity" :active="$currentRoute == 'activity'">
        <!-- button Icon -->
        {{-- <span class="material-symbols-outlined align-middle fs-2">
            event_note
        </span> --}}
        <i class="bi bi-person-lines-fill align-middle mr-4"></i>
        <span class="fs-6">Activity Log</span>
    </x-navLinks.link>

    <x-navLinks.link href="/archived/establishments" :active="$currentRoute == 'archived'">
        <!-- button Icon -->
        {{-- <span class="material-symbols-outlined align-middle fs-2">
            dresser
        </span> --}}
        <i class="bi bi-archive-fill align-middle mr-4"></i>
        <span class="fs-6">Archive</span>
    </x-navLinks.link>
</x-navLinks>
