<x-navLinks>
    <x-navLinks.link href="/fsec" :active="$currentRoute == 'fsec'">
        <span class="material-symbols-outlined align-middle fs-2">
            domain
        </span>
        Building Plan
    </x-navLinks.link>

    <x-navLinks.link href="/reports" :active="$currentRoute == 'reports'">
        <span class="material-symbols-outlined align-middle fs-2">
            receipt_long
        </span>
        Reports
    </x-navLinks.link>

    <x-navLinks.link href="/activity" :active="$currentRoute == 'activity'">
        <span class="material-symbols-outlined align-middle fs-2">
            event_note
        </span>
        Activity Log
    </x-navLinks.link>
</x-navLinks>
