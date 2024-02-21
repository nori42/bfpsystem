<x-navLinks>
    @php
        $currentRoute = Route::currentRouteName();
    @endphp
    <x-navLinks.link href="/dashboard" :active="$currentRoute == 'dashboard'">
        <i class="bi bi-microsoft align-middle mr-4"></i>
        <span class="fs-6">Dashboard</span>
    </x-navLinks.link>

    <x-navLinks.link href="/establishments" :active="$currentRoute == 'establishments'">
        <i class="bi bi-buildings-fill align-middle mr-4"></i>
        <span class="fs-6">Establishments</span>
    </x-navLinks.link>

    {{-- <x-navLinks.link href="/fsec" :active="$currentRoute == 'fsec'">
        <i class="bi bi-building-fill align-middle mr-4"></i>
        <span class="fs-6">Building Plan</span>
    </x-navLinks.link> --}}

    <x-navLinks.link href="/fireincidents" :active="$currentRoute == 'fireincidents'">
        <i class="bi bi-card-text align-middle mr-4"></i>
        <span class="fs-6">Fire Incidents</span>
    </x-navLinks.link>

    <x-navLinks.link href="/reports" :active="$currentRoute == 'reports'">
        <i class="bi bi-file-text-fill align-middle mr-4"></i>
        <span class="fs-6">Reports</span>
    </x-navLinks.link>

    <hr class="p-0 my-1 text-white border-3 mt-4 w-75 mx-auto border-primary-subtle">

    <x-navLinks.link href="/users" :active="$currentRoute == 'users'">
        <i class="bi bi-person-fill align-middle mr-4"></i>
        <span class="fs-6">Users</span>
    </x-navLinks.link>

    <x-navLinks.link href="/personnel" :active="$currentRoute == 'personnel'">
        <i class="bi bi-people-fill align-middle mr-4"></i>
        <span class="fs-6">Personnel</span>
    </x-navLinks.link>

    <hr class="p-0 my-1 text-white border-3 mt-4 w-75 mx-auto border-primary-subtle">

    <x-navLinks.link
        href="/activity?dateFrom={{ date('Y-m-d', strtotime(now())) }}&dateTo={{ date('Y-m-d', strtotime(now())) }}&activityIn=ALL"
        :active="$currentRoute == 'activity'">
        <i class="bi bi-person-lines-fill align-middle mr-4"></i>
        <span class="fs-6">Activity Log</span>
    </x-navLinks.link>

    <hr class="p-0 my-1 text-white border-3 w-75 mt-4 mx-auto border-primary-subtle">

    <x-navLinks.link href="/archived/establishments" :active="$currentRoute == 'archived'">
        <i class="bi bi-archive-fill align-middle mr-4"></i>
        <span class="fs-6">Archive</span>
    </x-navLinks.link>
</x-navLinks>
